<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Job;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display categories page.
     */
    public function index()
    {
        $categories = Category::withCount('jobs')
            ->latest()
            ->get();

        return view('admin.categories.category', compact('categories'));
    }

    /**
     * Store category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
        ]);

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'CATEGORY_ADDED',
            'description' => 'Category Added: ' . $category->name,
        ]);

        return back()->with('success', 'Category created successfully.');
    }

    /**
     * Update category.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:categories,name,' . $category->id,
            ],
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'CATEGORY_UPDATED',
            'description' => 'Category Updated: ' . $category->name,
        ]);

        return back()->with('success', 'Category updated successfully.');
    }

    /**
     * Delete category.
     */
    public function destroy(Category $category)
    {
        if ($category->jobs()->count() > 0) {

            return back()->with(
                'error',
                'Cannot delete category that has jobs.'
            );
        }
        $jobCount = Job::withTrashed()
            ->where('category_id', $category->id)
            ->count();

        if ($jobCount > 0) {
            return back()->with(
                'error',
                'Category cannot be deleted because jobs exist.'
            );
        }
        $category->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'CATEGORY_DELETED',
            'description' => 'Category Deleted: ' . $category->name,
        ]);

        return back()->with('success', 'Category deleted successfully.');
    }

    /**
     * Toggle status.
     */
    public function toggleStatus(Category $category)
    {
        $category->update([
            'is_active' => ! $category->is_active,
        ]);

        return back()->with('success', 'Category status updated.');
    }
}

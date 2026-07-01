{{-- ══════════════════════════════════════════════════════════
     GLOBAL IMAGE CROP MODAL  — included via master_index.blade.php
     Usage from any view:
       openCropModal('file-input-id', 'target-label', 'container-element-id')
     The container element's clientWidth/clientHeight is measured at runtime
     so the crop box always matches the exact display area.
══════════════════════════════════════════════════════════ --}}

<div id="crop-modal"
     class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden"
     style="background: rgba(0,0,0,0.65); backdrop-filter: blur(4px);">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden flex flex-col"
         style="max-height: 90vh;">

        {{-- ── Header ── --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 id="crop-modal-title" class="text-sm font-semibold text-gray-900">Crop Image</h3>
                    <p class="text-xs text-gray-400">Drag to reposition · Scroll to zoom</p>
                </div>
            </div>
            <button id="crop-cancel-btn" type="button"
                    class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- ── Crop Area ── --}}
        <div class="flex-1 overflow-hidden bg-gray-950 flex items-center justify-center"
             style="min-height: 300px; max-height: 55vh;">
            <img id="crop-image" src="" alt="Crop" style="max-width:100%; display:block;">
        </div>

        {{-- ── Controls ── --}}
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">

            {{-- Zoom / Rotate toolbar --}}
            <div class="flex items-center justify-center gap-2 mb-4">
                <button type="button" onclick="cropperInstance.zoom(-0.1)"
                        class="p-2 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 transition text-gray-600" title="Zoom out">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"/>
                    </svg>
                </button>
                <button type="button" onclick="cropperInstance.zoom(0.1)"
                        class="p-2 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 transition text-gray-600" title="Zoom in">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                    </svg>
                </button>
                <button type="button" onclick="cropperInstance.rotate(-90)"
                        class="p-2 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 transition text-gray-600" title="Rotate left">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </button>
                <button type="button" onclick="cropperInstance.rotate(90)"
                        class="p-2 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 transition text-gray-600" title="Rotate right">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20 4v5h-.582M4.644 11A8.001 8.001 0 0119.418 9M19.418 9H15m-11 11v-5h.581m0 0a8.003 8.003 0 0015.357-2M4.581 15H9"/>
                    </svg>
                </button>
                <button type="button" onclick="cropperInstance.reset()"
                        class="p-2 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 transition text-gray-600" title="Reset">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </button>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-3">
                <button id="crop-confirm-btn" type="button"
                        class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-gray-900 rounded-lg hover:bg-gray-700 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Apply Crop &amp; Upload
                </button>
                <button id="crop-cancel-btn2" type="button"
                        class="px-4 py-2.5 text-sm font-medium text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Cancel
                </button>
            </div>
        </div>

    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     GLOBAL CROP MODAL JAVASCRIPT
     openCropModal(inputId, target, containerId)
       inputId     — id of the hidden <input type="file"> to populate
       target      — arbitrary label string ('avatar','cover','logo', etc.)
       containerId — id of the element whose rendered size sets the crop ratio
                     and the output canvas size.
     After cropping the file is injected into the input.
     Each page's own confirm-handler reads _cropTarget to decide what to do next
     (e.g. update a preview and submit a specific form).
══════════════════════════════════════════════════════════ --}}
<script>
/* ─── state ─────────────────────────────────────────────── */
var cropperInstance  = null;
var _cropInputId     = null;
var _cropTarget      = null;   // e.g. 'avatar' | 'cover' | 'logo'
var _cropAspectRatio = 1;
var _cropContainerId = null;   // stored so confirm-handler can re-read dimensions

/* ─── open ───────────────────────────────────────────────── */
/**
 * Trigger the OS file picker, then show the crop modal.
 *
 * @param {string} inputId      id of the real <input type="file"> in the form
 * @param {string} target       label for the caller to identify what was cropped
 * @param {string} containerId  id of the element that displays the final image
 *                              — its clientWidth/clientHeight set the crop ratio
 */
function openCropModal(inputId, target, containerId) {
    _cropInputId     = inputId;
    _cropTarget      = target;
    _cropContainerId = containerId;

    /* measure the real display container to get an exact aspect ratio */
    var el = document.getElementById(containerId);
    if (el && el.clientHeight > 0) {
        _cropAspectRatio = el.clientWidth / el.clientHeight;
    } else {
        _cropAspectRatio = 1;
    }

    /* create a temporary picker — avoids re-using a stale input */
    var picker = document.createElement('input');
    picker.type    = 'file';
    picker.accept  = 'image/jpeg,image/jpg,image/png,image/webp';
    picker.style.display = 'none';
    document.body.appendChild(picker);

    picker.addEventListener('change', function () {
        if (!this.files || !this.files[0]) {
            document.body.removeChild(picker);
            return;
        }
        var file   = this.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            _showCropModal(e.target.result, file.name);
        };
        reader.readAsDataURL(file);
        document.body.removeChild(picker);
    });

    picker.click();
}

/* ─── show ───────────────────────────────────────────────── */
function _showCropModal(src, filename) {
    var modal = document.getElementById('crop-modal');
    var img   = document.getElementById('crop-image');

    /* title — pages can override _cropTarget to any string they like */
    var titles = { avatar: 'Crop Profile Photo', cover: 'Crop Cover Photo', logo: 'Crop Company Logo' };
    document.getElementById('crop-modal-title').textContent =
        titles[_cropTarget] || 'Crop Image';

    img.src = src;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    if (cropperInstance) { cropperInstance.destroy(); cropperInstance = null; }

    cropperInstance = new Cropper(img, {
        aspectRatio:  _cropAspectRatio,
        viewMode:     1,
        dragMode:     'move',
        autoCropArea: 0.9,
        restore:      false,
        guides:       true,
        center:       true,
        highlight:    false,
        cropBoxMovable:   true,
        cropBoxResizable: true,
        toggleDragModeOnDblclick: false,
    });

    cropperInstance._filename = filename || 'cropped.jpg';
}

/* ─── close ──────────────────────────────────────────────── */
function closeCropModal() {
    document.getElementById('crop-modal').classList.add('hidden');
    document.body.style.overflow = '';
    if (cropperInstance) { cropperInstance.destroy(); cropperInstance = null; }

    /* reset the confirm button label in case it was changed */
    var btn = document.getElementById('crop-confirm-btn');
    if (btn) { btn.disabled = false; btn.innerHTML = '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Apply Crop &amp; Upload'; }
}

/* ─── close triggers ─────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('crop-cancel-btn').addEventListener('click',  closeCropModal);
    document.getElementById('crop-cancel-btn2').addEventListener('click', closeCropModal);
    document.getElementById('crop-modal').addEventListener('click', function (e) {
        if (e.target === this) closeCropModal();
    });

    /* ── confirm / crop ──────────────────────────────────── */
    document.getElementById('crop-confirm-btn').addEventListener('click', function () {
        if (!cropperInstance) return;

        var btn = this;
        btn.disabled    = true;
        btn.textContent = 'Processing…';

        /* output at the exact rendered container size */
        var el   = document.getElementById(_cropContainerId);
        var outW = el ? el.clientWidth  : 800;
        var outH = el ? el.clientHeight : 800;

        cropperInstance.getCroppedCanvas({ width: outW, height: outH })
            .toBlob(function (blob) {

                var file = new File([blob], cropperInstance._filename || 'cropped.jpg', { type: blob.type });

                /* inject into the real hidden <input type="file"> */
                var realInput = document.getElementById(_cropInputId);
                if (realInput) {
                    var dt = new DataTransfer();
                    dt.items.add(file);
                    realInput.files = dt.files;
                }

                var dataUrl = URL.createObjectURL(blob);

                /* ── per-page preview + submit callbacks ──
                   Each page registers its own handler by setting
                   window.onCropConfirmed = function(target, dataUrl) { … }
                   If not set we just close the modal. */
                if (typeof window.onCropConfirmed === 'function') {
                    window.onCropConfirmed(_cropTarget, dataUrl);
                } else {
                    closeCropModal();
                }

            }, 'image/jpeg', 0.92);
    });
});
</script>

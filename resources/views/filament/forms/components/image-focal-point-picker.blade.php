@php
    $imageUrl = $getImageUrl();
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        x-data="{
            state: $wire.$entangle('{{ $getStatePath() }}'),
            dragging: false,
            init() {
                if (!this.state || typeof this.state !== 'object') {
                    this.state = { x: 50, y: 20 };
                }
            },
            movePoint(event) {
                const rect = this.$refs.picker.getBoundingClientRect();
                const x = Math.max(0, Math.min(100, ((event.clientX - rect.left) / rect.width) * 100));
                const y = Math.max(0, Math.min(100, ((event.clientY - rect.top) / rect.height) * 100));

                this.state = { x: Math.round(x), y: Math.round(y) };
            },
        }"
        class="space-y-3"
    >
        @if($imageUrl)
            <div
                x-ref="picker"
                class="relative overflow-hidden rounded-xl border border-gray-300 bg-gray-100 shadow-sm dark:border-gray-700 dark:bg-gray-900"
                style="touch-action: none; cursor: crosshair;"
                @pointerdown.prevent="dragging = true; movePoint($event); $el.setPointerCapture($event.pointerId)"
                @pointermove.prevent="if (dragging) movePoint($event)"
                @pointerup.prevent="dragging = false; $el.releasePointerCapture($event.pointerId)"
                @pointercancel="dragging = false"
            >
                <img
                    src="{{ $imageUrl }}"
                    alt="Chọn tâm ảnh cho chữ LOVE"
                    class="block h-auto w-full select-none"
                    draggable="false"
                >

                <div
                    class="pointer-events-none absolute h-8 w-8 -translate-x-1/2 -translate-y-1/2 rounded-full border-2 border-white bg-primary-500/70 shadow-lg ring-2 ring-black/30"
                    :style="`left: ${state?.x ?? 50}%; top: ${state?.y ?? 20}%`"
                >
                    <span class="absolute left-1/2 top-1/2 h-2 w-2 -translate-x-1/2 -translate-y-1/2 rounded-full bg-white"></span>
                </div>
            </div>

            <div class="flex items-center justify-between gap-3 text-sm text-gray-600 dark:text-gray-300">
                <span>
                    Kéo dấu ngắm vào khuôn mặt hoặc vùng cần giữ
                    · X: <strong x-text="state?.x ?? 50"></strong>%
                    · Y: <strong x-text="state?.y ?? 20"></strong>%
                </span>
                <button
                    type="button"
                    class="shrink-0 rounded-lg border border-gray-300 px-3 py-1.5 font-medium hover:bg-gray-50 dark:border-gray-600 dark:hover:bg-gray-800"
                    @click="state = { x: 50, y: 20 }"
                >
                    Đặt lại
                </button>
            </div>
        @else
            <p class="rounded-lg bg-gray-50 px-4 py-3 text-sm text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                Hãy tải ảnh riêng của template lên và lưu thiệp, sau đó mở lại để chọn vùng ảnh cần ưu tiên.
            </p>
        @endif
    </div>
</x-dynamic-component>

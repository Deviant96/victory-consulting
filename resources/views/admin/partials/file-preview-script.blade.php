@props([
    'inputId' => 'icon',
    'previewWrapperId' => 'icon-preview-wrapper',
    'previewId' => 'icon-preview',
])

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById({!! json_encode($inputId) !!});
        const previewWrapper = document.getElementById({!! json_encode($previewWrapperId) !!});
        const preview = document.getElementById({!! json_encode($previewId) !!});

        if (!input || !previewWrapper || !preview) {
            return;
        }

        input.addEventListener('change', () => {
            const file = input.files && input.files[0];
            if (!file) {
                previewWrapper.classList.add('hidden');
                preview.src = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = (event) => {
                preview.src = event.target.result;
                previewWrapper.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        });
    });
</script>

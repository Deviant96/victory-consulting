@props(['inputId' => 'icon', 'previewWrapperId' => 'icon-preview-wrapper', 'previewId' => 'icon-preview'])

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('{{ $inputId }}');
        const previewWrapper = document.getElementById('{{ $previewWrapperId }}');
        const preview = document.getElementById('{{ $previewId }}');

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

            // Validate file type
            const validTypes = ['image/jpeg', 'image/png', 'image/svg+xml'];
            if (!validTypes.includes(file.type)) {
                alert('Please select a valid image file (JPG, JPEG, PNG, or SVG)');
                input.value = '';
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

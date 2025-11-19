@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Use event delegation to handle delete button clicks
        // This works even when pagination changes the DOM content
        document.addEventListener('click', function(event) {
            // Check if the clicked element is a delete button
            if (event.target && event.target.classList.contains('delete-btn')) {
                event.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    //text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Find the closest form and submit it
                        const form = event.target.closest('form');
                        if (form) {
                            form.submit();
                        }
                    }
                });
            }
        });
    });
</script>
@endpush

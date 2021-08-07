<script>
    $(document).ready(function() {
        $("#post").height($("#post")[0].scrollHeight);
    });
    $('#post').on('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
</script>
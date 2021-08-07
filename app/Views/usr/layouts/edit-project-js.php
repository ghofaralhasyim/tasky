<script>
    $(document).ready(function() {
        $("#desc").height($("#desc")[0].scrollHeight);
    });
    $('#desc').on('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
    function deleteConfirm(url) {   
        $('#btn-delete-project').attr('href', url);
        $('#delete-project').modal();
    }
    function deleteTeam(url) {
        $('#btn-delete').attr('href', url);
        $('#delete_team').modal();
    }
</script>
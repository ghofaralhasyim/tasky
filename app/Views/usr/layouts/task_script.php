<script type="text/javascript">
    var IDtask = <?php $IDtask = $task['IDtask']; ?>
    $('#edt-task').click(function() {
        $('#desc').removeAttr('readonly').addClass('form-area-white').removeClass('form-area');
        $('#date').removeAttr('readonly').removeClass('deadline').addClass('deadline-edit');
        $('#edt-task').addClass('d-none');
        $('#delete-task').addClass('d-none');
        $('#save-task').removeClass('d-none');
        $('#title-form').removeClass('d-none');
        $('#task-title').addClass('d-none');
        $('#title').focus();
        $('#task-file').addClass('d-none');
    });

    function deleteConfirm(url) {
        $('#btn-delete').attr('href', url);
        $('#deleteModal').modal();
    }
    $('#desc').on('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    $(document).ready(function() {
        $("#desc").height($("#desc")[0].scrollHeight);
    });
</script>
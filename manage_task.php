<?php 
include 'db_connect.php';
session_start(); // Add this line
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM task_list where id = ".$_GET['id'])->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}
// echo ' test';
?>


<div class="container-fluid">
    <form action="" id="manage-task">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <input type="hidden" name="project_id" value="<?php echo isset($_GET['pid']) ? $_GET['pid'] : '' ?>">

        <?php
        $displayStyle = ($_SESSION['login_type'] == 3) ? 'style="display:none;"' : '';
        ?>

        <div class="form-group">
            <label <?php echo $displayStyle; ?> for="">Task</label>
            <input type="text" class="form-control form-control-sm" name="task" <?php echo $displayStyle; ?> value="<?php echo isset($task) ? $task : '' ?>" required>
        </div>

        <!-- This is the beginning of assigning subtask to staff -->
        <script>
            $(document).ready(function() {
                $('.select2').select2();
            });
        </script>

        <div class="col-md-6" <?php echo $displayStyle; ?>>
            <div class="form-group">
                <label for="" class="control-label">Staff(s) for the Task</label>
                <select class="form-control form-control-sm select2" multiple="multiple" name="user_ids[]">
                    <option></option>
                    <?php
                    $employees = $conn->query("SELECT *, CONCAT(firstname, ' ', lastname) as name FROM users WHERE type = 3 ORDER BY name ASC");
                    while ($row = $employees->fetch_assoc()):
                    ?>
                        <option value="<?php echo $row['id'] ?>" <?php echo isset($user_ids) && in_array($row['id'], explode(',', $user_ids)) ? "selected" : ''; ?>>
                            <?php echo ucwords($row['name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <!-- End of assigning subtask to staff -->

        <div class="form-group" <?php echo $displayStyle; ?>>
            <label for="">Description</label>
            <textarea name="description" id="" cols="30" rows="10" class="summernote form-control">
                <?php echo isset($description) ? $description : '' ?>
            </textarea>
        </div>

        <div class="form-group">
            <label for="">Status</label>
            <select name="status" id="status" class="custom-select custom-select-sm">
                <option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : ''; ?>>Pending</option>
                <option value="2" <?php echo isset($status) && $status == 2 ? 'selected' : ''; ?>>On-Progress</option>
                <option value="3" <?php echo isset($status) && $status == 3 ? 'selected' : ''; ?>>Done</option>
            </select>
        </div>
    </form>
</div>

<script>
	$(document).ready(function(){


	$('.summernote').summernote({
        height: 200,
        toolbar: [
            [ 'style', [ 'style' ] ],
            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
            [ 'fontname', [ 'fontname' ] ],
            [ 'fontsize', [ 'fontsize' ] ],
            [ 'color', [ 'color' ] ],
            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
            [ 'table', [ 'table' ] ],
            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
        ]
    })
     })
    
    $('#manage-task').submit(function(e){
    	e.preventDefault()
    	start_load()
    	$.ajax({
    		url:'ajax.php?action=save_task',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved',"success");
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
    	})
    })
</script>
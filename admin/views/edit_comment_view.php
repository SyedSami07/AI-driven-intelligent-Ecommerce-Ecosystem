<?php 
    // 1. Handle Initial Data Fetch (When page first loads)
    if(isset($_GET['id'])){
        $comment_id = $_GET['id'];
        $array = $obj->edit_comment($comment_id);
        
        if($array){
            $row = mysqli_fetch_assoc($array);
        }
    }

    // 2. Handle Update Logic
    if(isset($_POST['update_comment'])){
       $update_msg = $obj->update_comment($_POST);
       
       // Refresh $row so the textarea shows the newly updated text
       $comment_id = $_POST['cmt_id'];
       $array = $obj->edit_comment($comment_id);
       $row = mysqli_fetch_assoc($array);
    }

    // 3. Safety Check: If $row is still empty (invalid ID), redirect or show error
    if(!isset($row)){
        echo "<div class='alert alert-danger'>Error: Comment data not found.</div>";
        exit();
    }
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Edit Customer Feedback</h4>
                    <a href="customer_feedback.php" class="btn btn-light btn-sm">Back to List</a>
                </div>
                
                <div class="card-body">
                    <?php 
                        $ai_status = $obj->check_cyberbullying($row['comment']); 
                    ?>
                    <div class="mb-3">
                        AI Safety Status: 
                        <?php if($ai_status == 1): ?>
                            <span class="badge badge-danger">Cyberbullying Detected</span>
                        <?php else: ?>
                            <span class="badge badge-success">Safe Content</span>
                        <?php endif; ?>
                    </div>

                    <?php if(isset($update_msg)): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> <?php echo $update_msg; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <div class="row mb-4">
                        <div class="col-sm-4 font-weight-bold text-muted text-uppercase small">Customer Info</div>
                        <div class="col-sm-8">
                            <ul class="list-unstyled p-3 bg-light rounded border">
                                <li><strong>User ID:</strong> #<?php echo $row['user_id']; ?></li>
                                <li><strong>User Name:</strong> <?php echo htmlspecialchars($row['user_name']); ?></li>
                                <li><strong>Product ID:</strong> #<?php echo $row['pdt_id']; ?></li>
                            </ul>
                        </div>
                    </div>

                    <hr>

                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="u_comment" class="font-weight-bold">Update Comment Content:</label>
                            <input type="hidden" name="cmt_id" value="<?php echo $row['id']; ?>">
                            <textarea 
                                name="u_comment" 
                                id="u_comment" 
                                class="form-control" 
                                rows="6" 
                                placeholder="Edit the user comment here..."
                                required><?php echo htmlspecialchars($row['comment']); ?></textarea>
                        </div>

                        <div class="form-group mt-4 text-right">
                            <input type="submit" value="Update Feedback" name="update_comment" class="btn btn-primary px-5 shadow-sm">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
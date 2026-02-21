<?php 
    // 1. Handle Delete Action
    if (isset($_GET['status']) && $_GET['status'] == 'deletecomment' && isset($_GET['id'])) {
        $comment_id = (int)$_GET['id']; 
        $del_msg = $obj->delete_comment($comment_id);
    }

    // 2. Fetch the data - Now includes the 'ai_status' column from your DB
    $cmt_info = $obj->view_comment_all();
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 font-weight-bold text-dark">Manage Customer Feedback</h2>
        <span class="badge p-2" style="background-color: #17a2b8; color: white;">
            <i class="fas fa-robot"></i> AI Moderation Active
        </span>
    </div>

    <?php if (isset($del_msg)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Action:</strong> <?php echo $del_msg; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card shadow border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>User Name</th>
                            <th>Product</th>
                            <th>User Comment</th>
                            <th>AI Safety Status</th> 
                            <th>Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                            if ($cmt_info) {
                                while ($cmt_row = mysqli_fetch_assoc($cmt_info)) {
                                    // We NO LONGER call the API here. 
                                    // We use the value saved in the database 'ai_status'
                                   $saved_status = $cmt_row['ai_status'] ?? 0;
                        ?>
                        <tr>
                            <td>#<?php echo $cmt_row['id']; ?></td>
                            <td><strong><?php echo htmlspecialchars($cmt_row['user_name']); ?></strong></td>
                            <td><small class="text-muted">PID: <?php echo $cmt_row['pdt_id']; ?></small></td>
                            <td style="max-width: 300px; word-wrap: break-word;">
                                <?php echo htmlspecialchars($cmt_row['comment']); ?>
                            </td>
                            
                            <td class="text-center">
                                <?php if ($saved_status == 1): ?>
                                    <span class="badge p-2" style="background-color: #dc3545; color: white; min-width: 140px;">
                                        <i class="fas fa-exclamation-triangle"></i> Cyberbullying
                                    </span>
                                <?php else: ?>
                                    <span class="badge p-2" style="background-color: #28a745; color: white; min-width: 140px;">
                                        <i class="fas fa-check-circle"></i> Safe
                                    </span>
                                <?php endif; ?>
                            </td>

                            <td><small><?php echo date("d M, Y", strtotime($cmt_row['comment_date'])); ?></small></td>
                            
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="edit_comment.php?status=editcomment&id=<?php echo $cmt_row['id']; ?>" 
                                       class="btn btn-sm btn-outline-warning">
                                       <i class="fas fa-edit"></i> Edit
                                    </a>
                                    
                                    <a href="?status=deletecomment&id=<?php echo $cmt_row['id']; ?>" 
                                       class="btn btn-sm btn-outline-danger" 
                                       onclick="return confirm('Warning: This will permanently remove the feedback. Continue?')">
                                       <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php 
                                } 
                            } else {
                                echo "<tr><td colspan='7' class='text-center'>No feedback found.</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .table td { vertical-align: middle !important; }
    .badge { font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border-radius: 4px; }
    .btn-group .btn { margin: 0 2px; }
    .thead-dark th { background-color: #343a40; color: white; }
</style>
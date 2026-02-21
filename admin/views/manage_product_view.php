<?php 
    $obj = new adminback();

    // 1. ACTION LOGIC (Run this first!)
    if(isset($_GET['prostatus'])){
        $id = $_GET['id'];
        if($_GET['prostatus']=='published'){
            $obj->published_product($id);
        }elseif($_GET['prostatus']=='unpublished'){
            $obj->unpublished_product($id);
        }elseif($_GET['prostatus']=="delete"){
            $del_msg = $obj->delete_product($id);
        }
    }

    // 2. FETCH LOGIC (Run this after actions so data is fresh)
    $product_info = $obj->display_product();
?>

<h2>Manage Product </h2> 
<br>

<?php if(isset($del_msg)): ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Notice:</strong> <?php echo $del_msg; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>Image</th>
            <th>Status</th>
            <th>Category</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php while($pdt = mysqli_fetch_assoc($product_info)) { ?>
        <tr>
            <td><?php echo $pdt['pdt_name'] ?></td>
            <td><?php echo $pdt['pdt_price'] ?></td>
            <td>
                <img style="height:60px; width:60px; object-fit:cover;" src="uploads/<?php echo $pdt['pdt_img'] ?>" alt="Product">
            </td>
            <td> 
                <?php if($pdt['pdt_status'] == 0): ?>
                    <span class="text-danger">Unpublished</span> <br>
                    <a href="?prostatus=published&id=<?php echo $pdt['pdt_id']?>" class="btn btn-sm btn-primary">Make Published</a>
                <?php else: ?>
                    <span class="text-success">Published</span> <br>
                    <a href="?prostatus=unpublished&id=<?php echo $pdt['pdt_id'] ?>" class="btn btn-sm btn-warning">Make Unpublished</a>
                <?php endif; ?>
            </td>
            <td><?php echo $pdt['ctg_name'] ?></td>
            <td>
                <a href="edit_product.php?prostatus=edit&id=<?php echo $pdt['pdt_id'] ?>" class="btn btn-sm btn-info">Edit</a>
                <a href="?prostatus=delete&id=<?php echo $pdt['pdt_id'] ?>" 
                   class="btn btn-sm btn-danger" 
                   onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
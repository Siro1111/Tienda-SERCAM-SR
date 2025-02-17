<?php include '../../config/session.php'; ?>
<?php include '../../helpers/helpers.php'; ?>

<?php include '../templates/head.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php include '../templates/navbar.php'; ?>
        <?php include '../templates/menubar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Lista de productos
                </h1>
                <ol class="breadcrumb">
                    <li><a href="<?=$url?>/administrador/home.php"><i class="fa fa-home"></i> Principal</a></li>
                    <li><i class="fa fa-tags"></i><b>Productos</b></li>
                    <li class="active">Lista de productos</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <?php 
        include('../includes/alerts.php');
      ?>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"
                                    id="addproduct"><i class="fa fa-plus"></i> Nuevo</a>
                                <div class="pull-right">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label>Categoria: </label>
                                            <select class="form-control input-sm" id="select_category">
                                                <option value="0">Todos</option>
                                                <?php
                    
                        $where = '';
                        $catid = (isset($_GET['category'])) ? (int)$_GET['category'] : null;
                        if(isset($catid)){  $where = 'WHERE id ='.$catid;  }
                       
                        $stmt = $conexion -> prepare("SELECT * FROM products_category WHERE status=true");
                        $stmt -> execute();

                        foreach($stmt as $crow){
                            $selected = ($crow['id'] == $catid) ? 'selected' : ''; 
                            echo "
                              <option value='".$crow['id']."' ".$selected.">".$crow['identity']."</option>
                            ";
                          } ?>

                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="box-body">
                                <table id="example1" class="table table-bordered">
                                    <thead>
                                        <th>Nombre</th>
                                        <th>Foto</th>
                                        <th>Descripción</th>
                                        <th>Precio</th>
                                        <th>Vistas hoy</th>
                                        <th>Stock</th>
                                        <th>Herramientas</th>
                                    </thead>
                                    <tbody>
                                        <?php
                 
                        $date = date('Y-m-d');
                       
                        $productsView = showProductbyCategory($conexion, $catid);

                        foreach($productsView as $prod) :
                            $prod_Img = (!empty($prod['photo'])) ? $prod['photo'] : 'product.png';
                            $counter = ($prod['date_view'] == $date) ? $prod['counter'] : 0; 
                             $active= (!$prod['status']) ? `<span class="pull-right"><a href="#activate" class="status" data-toggle="modal" data-id=""><i class="fa fa-check-square-o"></i></a></span>` : '';
                            $status_prod = ($prod['stock']>0) ? '<span class="label label-success">En Stock</span>' : '<span class="label label-danger">Sin Stock</span>';
                            ?>

                        <tr>
                            <td><?=$prod['name']?></td>
                            <td>
                                <img src="<?=$url?>/administrador/assets/img/products/<?=$prod_Img?>" height='30px' width='30px'>
                                <span class='pull-right'>
                                    <a href='#edit_photo'class='photo'data-toggle='modal'data-id="<?=$prod['id']?>"><i class='fa fa-edit'></i>
                                    </a>
                                </span>
                            </td>
                            <td>
                                <a href='#description' data-toggle='modal'class='btn btn-info btn-sm btn-flat desc' data-id='<?=$prod['id']?>'>
                                <i class='fa fa-search'></i> Ver </a>
                            </td>
                            <td>&#36; <?=number_format($prod['price_sale'], 2)?></td>
                            <td><?=$counter?></td>
                            <td><?=$status_prod .' '.$active ?></td>
                            <td>
                            <button class='btn btn-success btn-sm edit btn-flat' data-id='<?=$prod['id']?>'><i class='fa fa-edit'></i> </button>
                            <button class='btn btn-danger btn-sm delete btn-flat' data-id='<?=$prod['id']?>'><i class='fa fa-trash'></i></button>
                            </td>
                        </tr>



                                    <?php endforeach; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
       


       

    </div>

    <!-- ./wrapper -->
    <?php include '../templates/footer.php'; ?>
    <?php include './products/products_modal.php'; ?>
    <?php include './products/products_modal_II.php'; ?>
    <?php include '../script/script-main.php'; ?>
    <?php include '../script/script-products.php'; ?>

</body>

</html>
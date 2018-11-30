<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">

            <div class="panel panel-default">


                <div class="panel-body">
                    <?php if(session('status')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class="btn btn-group cen">
                                    <a href="wlists/create" class="btn btn-primary">
                                        <i class="fa fa-plus-square"></i> <?php echo app('translator')->getFromJson("New List"); ?>
                                    </a>
                                    

                                    <a href="<?php echo e(url('/wlists')); ?>" class="btn btn-success">
                                        <i class="fa fa-edit"></i> <?php echo e(__('My Lists')); ?>

                                    </a>

                                </div>
                            </div>
                        </div>
                     <?php
                     /*
                      * date: 30/12/17
                      * time: 11:36
                      * user: Francesco
                      *
                      * recupero l'id_user_profile dell'utente loggato, visto che al momento ogni utente
                      * ha un solo user_profile
                      *
                      * @TODO: migliorare quest'aspetto, l'utente deve poter scegliere il proprio profilo
                      */
                     $id_up  = (\Auth::user()->user_profiles)[0]['id_user_profile'];
                     $state  = 0;
                     $fsr_s  = \Weeesh\Http\Controllers\FsRequestController::getFSRequests($id_up, $state);
                     ?>

                        <?php if(count($fsr_s)>0): ?>

                            <br clear="all" />

                            <?php echo app('translator')->getFromJson("Friendship Requests"); ?>
                            <br clear="all" />

                            <table class="table table-striped responsive" >
                                <thead>
                                <tr>
                                    <th> <?php echo app('translator')->getFromJson("Name"); ?></th>
                                    <th colspan="2"><?php echo app('translator')->getFromJson("Action"); ?></th>
                                </tr>
                                </thead>

                                <tbody>

                                <?php $__currentLoopData = $fsr_s; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fsr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo e($fsr->user_profile_by->name); ?>

                                        <?php echo e($fsr->user_profile_by->surname); ?>

                                    </td>
                                    <td>
                                        <form action="<?php echo e(action('FsRequestController@update',$fsr->id_fs_request)); ?>" method="post">
                                            <?php echo e(csrf_field()); ?>

                                            <input name="_method" type="hidden" value="PATCH">
                                            <button class="btn btn-primary" type="submit"><?php echo app('translator')->getFromJson("Accept"); ?></button>
                                            <input type="hidden" name="id_fs_request_state" value="1"/>

                                        </form>
                                    </td>
                                    <td>
                                        <form action="<?php echo e(action('FsRequestController@update',$fsr->id_fs_request)); ?>" method="post">
                                            <?php echo e(csrf_field()); ?>

                                            <input name="_method" type="hidden" value="PATCH">
                                            <button class="btn btn-primary" type="submit"><?php echo app('translator')->getFromJson("Deny"); ?></button>
                                            <input type="hidden" name="id_fs_request_state" value="2">

                                        </form>
                                    </td>
                                 </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>

                        <?php endif; ?>


                        <!-- @TODO: mostrare elenco degli ultimi regali inseriti -->
                        <div class="panel-group">

                            <div class="panel panel-default feed">
                                <div class="panel-body feed-body">

                                    <div class="row">
                                        <div class="col-xs-12 nome">Sara Mollo</div>

                                    </div>
                                    <div class="row">
                                        <div class="nomelista col-xs-8">Compleanno 2018</div>
                                        <div class="col-xs-4 data">13/06/2018</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-2 stato"><i class="fas fa-cart-arrow-down"></i></div>
                                        <div class="col-xs-10 oggetto">Telefono</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-2 stato"><i class="fas fa-cart-arrow-down"></i></div>
                                        <div class="col-xs-10 oggetto">lavastoviglie</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-2 stato"><i class="fas fa-cart-arrow-down"></i></div>
                                        <div class="col-xs-10 oggetto">auto</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-2 stato"><i class="fas fa-cart-arrow-down"></i></div>
                                        <div class="col-xs-10 oggetto">scarpe</div>
                                    </div>
                                </div>
                            </div>


                            <div class="panel panel-default feed">
                                <div class="panel-body feed-body">

                                    <div class="row">
                                        <div class="col-xs-12 nome">Sara Mollo</div>

                                    </div>
                                    <div class="row">
                                        <div class="nomelista col-xs-8">Compleanno 2018</div>
                                        <div class="col-xs-4 data">13/06/2018</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-2 stato"><i class="fas fa-cart-arrow-down"></i></div>
                                        <div class="col-xs-10 oggetto">Telefono</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-2 stato"><i class="fas fa-cart-arrow-down"></i></div>
                                        <div class="col-xs-10 oggetto">lavastoviglie</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-2 stato"><i class="fas fa-cart-arrow-down"></i></div>
                                        <div class="col-xs-10 oggetto">auto</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-2 stato"><i class="fas fa-cart-arrow-down"></i></div>
                                        <div class="col-xs-10 oggetto">scarpe</div>
                                    </div>
                                </div>
                            </div>


                        </div>

                </div>
            </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
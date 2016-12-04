<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <?php echo e(Form::model($user, array('route' => array('profile', $user->id), 'method' => 'PUT'))); ?>            
                        <div class="form-group">
                            <label for="login" class="col-md-4 control-label">Логин</label>

                            <div class="col-md-6">
                                <input id="login" type="text" class="form-control" name="login" value="<?php echo e($user->login); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="full_name" class="col-md-4 control-label">Полное имя</label>

                            <div class="col-md-6">
                                <input id="full_name" type="text" class="form-control" name="full_name" value="<?php echo e($user->full_name); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birthday" class="col-md-4 control-label">Дата рождения</label>

                            <div class="col-md-6">
                                <input id="birthday" type="date" class="form-control" name="birthday" value="<?php echo e($user->birthday); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="<?php echo e($user->email); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-4 control-label">Адрес</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" value="<?php echo e($user->address); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="city" class="col-md-4 control-label">Город</label>

                            <div class="col-md-6">
                                <input id="city" type="text" class="form-control" name="city" value="<?php echo e($user->city); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="state" class="col-md-4 control-label">Регион</label>

                            <div class="col-md-6">
                                <input id="state" type="text" class="form-control" name="state" value="<?php echo e($user->state); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="country" class="col-md-4 control-label">Страна</label>

                            <div class="col-md-6">
                                <input id="country" type="text" class="form-control" name="country" value="<?php echo e($user->country); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pzip" class="col-md-4 control-label">Индекс</label>

                            <div class="col-md-6">
                                <input id="pzip" type="text" class="form-control" name="pzip" value="<?php echo e($user->zip); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Пароль</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Подтверждение пароля</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Register
                                </button>
                            </div>
                        </div>
                    <?php echo Form::close(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
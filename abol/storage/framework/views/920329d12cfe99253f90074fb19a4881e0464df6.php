<?php $__env->startSection('content'); ?>
 <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Управление пользователями <span id="msg"></span></div>
                <h1 id="msg"></h1>
                <div class="panel-body">
                	<?php echo Form::open(array('url'=>'post/edit', 'method'=>'POST', 'id'=>'myform', 'action'=>'HomeController@editusers')); ?>

                	  <table class="table table-hover">
					    <thead>
					      <tr>
					      	<th>ID</th>
					      	<th>Роль</th>
					        <th>Логин</th>
					        <th>Полное имя</th>
					        <th>Email</th>
					      </tr>
					    </thead>
					    <tbody>
				    	<?php foreach($users as $user): ?>
					      <tr>
					      	<td><?php echo e($user->id); ?></td>
					      	<td>
				      		 	<select class="form-control" id="sel<?php echo e($user->id); ?>">
							        <option value="3">Администратор</option>
							        <option value="1">Модератор</option>
							        <option value="0">Пользователь</option>
							    </select>
								<script>
									$(function(){ $( "#sel<?php echo e($user->id); ?>" ).val(<?php echo e($user->group); ?>);});
								</script>
				      		</td>
					      	<td><input type="text" value="<?php echo e($user->login); ?>" id="login<?php echo e($user->id); ?>"></td>
					      	<td><input type="text" value="<?php echo e($user->email); ?>" id="email<?php echo e($user->id); ?>"></td>
					        <td><input type="text" value="<?php echo e($user->full_name); ?>" id="fullname<?php echo e($user->id); ?>"></td>
					        <td><button type="button" class="btn btn-success" onclick="saveUsCh(<?php echo e($user->id); ?>)" >Сохранить</button></td>
					      </tr>
                    	<?php endforeach; ?>
					    </tbody>
					  </table>
					<?php echo Form::close(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">

function saveUsCh(id){
 	var group=$('#sel'+id).val();
 	var login=$('#login'+id).val();
 	var email=$('#email'+id).val(); 
 	var fullname=$('#fullname'+id).val();
	$.ajax({
	   type:'POST',
	   url:'admin/edit',
	   data: {id: id, gr: group, lg: login, em: email, fn: fullname, _token: "<?php echo csrf_token()?>"},
	   success:function(data){
	      $("#msg").html(data.msg);
   		}
	});
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
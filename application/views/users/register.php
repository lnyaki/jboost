<div class="container">
	<div class="col-md-7">
    	<h2 class="section-title no-margin-top">Create Account</h2>
        <div class="panel panel-success-dark animated fadeInDown">
        	<div class="panel-heading">Register Form</div>
            	<div class="panel-body">
            		<?php $this->load->library('form_validation');
            		echo validation_errors(); ?>
                	<form method="post" role="form" action="users/process/process_registration">
                    	<div class="form-group">
                        	<label for="InputUserName">User Name<sup>*</sup></label>
                            	<input type="text" class="form-control" name="user" id="user">
                        </div>
                        <div class="form-group">
                             <label for="InputFirstName">First Name</label>
                             <input type="text" class="form-control" id="InputFirstName">
                        </div>
                        <div class="form-group">
                        	<label for="InputLastName">Last Name</label>
                        	<input type="text" class="form-control" id="InputLastName">
                        </div>
                        <div class="form-group">
                        	<label for="InputEmail">Email<sup>*</sup></label>
                        	<input type="email" class="form-control" name="email" id="email">
                        </div>
                        <div class="row">
                        	<div class="col-md-6">
                            	<div class="form-group">
                                	<label for="InputPassword">Password<sup>*</sup></label>
                                    <input type="password" class="form-control" name="pass1" id="pass1">
                                </div>
                            </div>
                            <div class="col-md-6">
                            	<div class="form-group">
                                	<label for="InputConfirmPassword">Confirm Password<sup>*</sup></label>
                                    <input type="password" class="form-control" name="pass2" id="pass2">
                                </div>
                            </div>
                     	</div>
                        <div class="row">
                        	<div class="col-md-8">
                            	<label class="checkbox-inline">
                                 	<input type="checkbox" id="inlineCheckbox1" value="option1"> I read <a href="#">Terms and Conditions</a>.
                                </label>
                            </div>
                         	<div class="col-md-4">
                         		<button type="submit" class="btn btn-ar btn-primary pull-right">Register</button>
                       		</div>
                        </div>
               		</form>
            	</div>
          	</div>
       </div>
</div>
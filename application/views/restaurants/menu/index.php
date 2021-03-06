<!--page content-->
<div class="row">
	<div class="col-sm-12">
		<div class="white-box">
			<?php if (!empty($this->session->flashdata('success'))) { ?>
				<p class="text-mutedv text-success m-b-30">    <?= $this->session->flashdata('success'); ?> </p>
			<?php } ?>
			<?php if (!empty($this->session->flashdata('error'))) { ?>
				<p class="text-mutedv text-danger m-b-30">    <?= $this->session->flashdata('error'); ?> </p>
			<?php } ?>
			<div class="form-group">
				<form data-toggle="validator"
					  action="<?php echo base_url('admin/restaurants/menu/store/') . $id ?>"
					  method="post">
					<div class="table-responsive">
						<table class="table table-bordered" id="dynamic_field">
							<tr>
								<td>
									<input type="text" name="name[]" placeholder="Enter narguile name"
										   class="form-control m-b-5"/>
									<input type="text" name="price[]" placeholder="Enter narguile price"
										   class="form-control"/>
								</td>

								<td>
									<button type="button" name="add" id="add" class="btn btn-success">Add More</button>
								</td>
							</tr>
						</table>
						<input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit"/>
						<a href="<?= base_url("admin/restaurants/show/") . $id ?>">
							<button type="button" class="btn btn-basic">Return</button>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!--page content-->
<div class="row">
	<div class="col-sm-12">
		<div class="white-box">
			<form data-toggle="validator"
				  action="<?php echo base_url('admin/restaurants/menu/image-store/') . $id ?>"
				  method="post" enctype="multipart/form-data">

				<div class="form-group">
					<?php if (isset($this->errors)) { ?>
						<div class="alert-danger alert-dismissable">
							<?= $this->errors; ?>
						</div>
					<?php } ?>
					<label>Food bar and menu's images (Choose Multiple) </label>
					<br>
					<input type="file" name="images[]" class="form-control" multiple>
				</div>

				<div class="form-group">
					<input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit"/>
					<a href="<?= base_url("admin/restaurants/show/") . $id ?> ">
						<button type="button" class="btn btn-basic">Return</button>
					</a>
				</div>
			</form>
		</div>
	</div>
</div>

<!--page content-->
<div class="row">
	<div class="col-sm-12">
		<div class="white-box">
			<div class="table-responsive">
				<table id="myTable" class="table table-striped">
					<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Price</th>
						<th>Status</th>
						<th>Options</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($menu as $key => $value) { ?>
						<tr>
							<td><?= $key + 1 ?></td>
							<td><?= $value->name; ?></td>
							<td><?= $value->price; ?></td>
							<td style="
									<?php if ($value->status == 0) {
								echo 'color: red;';
							} else {
								echo 'color: green;';
							} ?>">
								<?php if ($value->status == 0) {
									echo "Inactive";
								} else {
									echo "Active";
								} ?>
							</td>
							<td>
								<a href="<?= base_url("admin/restaurants/menu/edit/$value->id") ?>"
								   data-toggle="tooltip"
								   data-placement="top" title="Edit" class="btn btn-info btn-circle tooltip-info"> <i
										class="fas fa-pencil-alt"></i> </a>

								<?php if ($value->status == 1) { ?>
									<a href="<?= base_url("admin/restaurants/menu/change-status/$value->id") ?>"
									   data-toggle="tooltip"
									   data-placement="top" title="Deactivate"
									   class="btn btn-danger btn-circle tooltip-danger"><i class="fa fa-power-off"></i></a>
								<?php } else { ?>
									<a href="<?= base_url("admin/restaurants/menu/change-status/$value->id") ?>"
									   data-toggle="tooltip"
									   data-placement="top" title="Activate"
									   class="btn btn-success btn-circle tooltip-success"><i
											class="fa fa-power-off"></i></a>
								<?php } ?>
							</td>

						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!--page content-->
<div class="row">
	<div class="col-sm-12">
		<div class="white-box">
			<div class="table-responsive">
				<table id="myTable" class="table table-striped">
					<thead>
					<tr>
						<th>ID</th>
						<th>Image</th>
						<th>Status</th>
						<th>options</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($menu_images as $key => $value) { ?>
						<tr>
							<td><?= $key + 1 ?></td>
							<td>
								<img src="<?= base_url('/plugins/images/Menu/') . $value->image ?> " alt="image"
									 class="img-responsive" width="200" height="200">
							</td>
							<td style="
									<?php if ($value->status == 0) {
								echo 'color: red;';
							} else {
								echo 'color: green;';
							} ?>">
								<?php if ($value->status == 0) {
									echo "Inactive";
								} else {
									echo "Active";
								} ?>
							</td>

							<td>
								<?php if ($value->status == 1) { ?>
									<a href="<?= base_url("admin/restaurants/menu/change-status-image/$value->id") ?>"
									   data-toggle="tooltip"
									   data-placement="top" title="Deactivate"
									   class="btn btn-danger btn-circle tooltip-danger"><i class="fa fa-power-off"></i></a>
								<?php } else { ?>
									<a href="<?= base_url("admin/restaurants/menu/change-status-image/$value->id") ?>"
									   data-toggle="tooltip"
									   data-placement="top" title="Activate"
									   class="btn btn-success btn-circle tooltip-success"><i
											class="fa fa-power-off"></i></a>
								<?php } ?>
							</td>

						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
    $(document).ready(function () {
        var i = 1;
        $('#add').click(function () {
            i++;
            $('#dynamic_field').append(`<tr id="row${i}"><td>
			<input type="text" name="name[]" placeholder="Enter narguile name" class="form-control m-b-5" />
			<input type="text" name="price[]" placeholder="Enter narguile price" class="form-control"/></td>
			<td><button type="button" name="remove" id="${i}" class="btn btn-danger btn_remove">X</button></td></tr>`);
        });

        $(document).on('click', '.btn_remove', function () {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });
    });
</script>

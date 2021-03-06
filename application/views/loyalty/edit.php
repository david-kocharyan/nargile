<div class="col-md-12 col-sm-12">
	<div class="white-box">
		<h3 class="box-title m-b-0">Edit loyalty card</h3>

		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<form action="<?= base_url("admin/loyalty/update/$loyalty->id") ?>" method="post">

					<div class="form-group">
						<label for="inputUsername" class="control-label">Description</label>
						<input type="text" class="form-control" id="inputUsername" placeholder="Description" name="desc"
							   required value="<?= $loyalty->desc; ?>">
						<?php if (!empty(form_error('desc'))) { ?>
							<div class="help-block with-errors text-danger">
								<?= form_error('desc'); ?>
							</div>
						<?php } ?>
					</div>

					<div class="form-group">
						<label for="inputUsername" class="control-label">Until Date</label>
						<input type="date" class="form-control" id="inputUsername" name="valid_date"
							   required value="<?= date('Y-m-d', $loyalty->valid_date); ?>">
						<?php if (!empty(form_error('valid_date'))) { ?>
							<div class="help-block with-errors text-danger">
								<?= form_error('valid_date'); ?>
							</div>
						<?php } ?>
					</div>

					<div class="form-group">
						<label for="inputUsername" class="control-label">Percent</label>
						<input type="number" class="form-control" id="inputUsername" placeholder="Persent"
							   name="percent"
							   required value="<?= $loyalty->percent; ?>">
						<?php if (!empty(form_error('percent'))) { ?>
							<div class="help-block with-errors text-danger">
								<?= form_error('percent'); ?>
							</div>
						<?php } ?>
					</div>

					<div class="form-group">
						<label for="inputUsername" class="control-label">QR Code</label>
						<input type="text" class="form-control" id="inputUsername" placeholder="QR Code" name="qr"
							   value="<?= $this->input->post("qr"); ?>">
						<?php if (!empty(form_error('qr'))) { ?>
							<div class="help-block with-errors text-danger">
								<?= form_error('qr'); ?>
							</div>
						<?php } ?>
					</div>


					<div class="text-right">
						<button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Edit</button>
						<a href="<?= base_url("admin/loyalty") ?>">
							<button type="button" class="btn btn-inverse waves-effect waves-light">Return</button>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="col-md-4 col-sm-12">
	<div class="white-box">
		<h3 class="box-title m-b-0">Sample Forms with Right icon</h3>

		<?php if (!empty($this->session->flashdata('success'))) { ?>
			<p class="text-muted m-b-30 font-13"> Bootstrap Elements </p>
			<p class="text-mutedv text-success m-b-30">  <?= $this->session->flashdata('success'); ?> </p>
		<?php } else { ?>
			<p class="text-muted m-b-30 font-13"> Bootstrap Elements </p>
		<?php } ?>

		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<form action="<?= base_url("admin/area/store") ?>" method="post">

					<div class="form-group">
						<label for="area">Area Name</label>
						<?php if (!empty(form_error('area'))) { ?>
							<div class="help-block with-errors text-danger">
								<?= form_error('area'); ?>
							</div>
						<?php } ?>
						<div class="input-group">
							<input type="text" class="form-control" id="area" placeholder="Area name"
								   name="area">
							<div class="input-group-addon"><i class="ti-target"></i></div>
						</div>
					</div>

					<div class="form-group">
						<label for="country">Country</label>
						<div class="input-group">
							<select class="form-control select_2_example" id="country" name="country">
								<?php foreach ($countries as $key) { ?>
									<option value="<?= $key->id ?>">
										<?= $key->name ?>
									</option>
								<?php } ?>
							</select>
							<div class="input-group-addon"><i class="ti-world"></i></div>
						</div>
					</div>

					<div class="text-right">
						<button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
						<a href="<?= base_url("admin/area") ?>">
							<button type="button" class="btn btn-inverse waves-effect waves-light">Return</button>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>

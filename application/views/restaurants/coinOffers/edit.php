<!--page content-->
<div class="row">
	<div class="col-sm-12">
		<div class="white-box">
			<form data-toggle="validator"
				  action="<?= base_url("admin/restaurants/coin-offers/update/") ?><?= $coins->id ?>"
				  method="post">

				<div class="form-group">
					<label for="inputInfo" class="control-label">Price</label>
					<input type="text" class="form-control" id="inputInfo" name="price"
						   value="<?= $coins->price ?>"
						   required>
					<?php if (!empty(form_error('price'))) { ?>
						<div class="help-block with-errors text-danger">
							<?= form_error('price'); ?>
						</div>
					<?php } ?>
				</div>

				<div class="form-group">
					<label for="inputInfo" class="control-label">Valid until</label>
					<input type="text" class="form-control" id="inputInfo" name="date"
						   value="<?= date("Y-m-d", $coins->valid_date) ?>"
						   required>
					<?php if (!empty(form_error('date'))) { ?>
						<div class="help-block with-errors text-danger">
							<?= form_error('date'); ?>
						</div>
					<?php } ?>
				</div>

				<div class="form-group">
					<label for="inputInfo" class="control-label">Description</label>
					<input type="text" class="form-control" id="inputInfo" name="desc"
						   value="<?= $coins->description ?>"
						   required>
					<?php if (!empty(form_error('desc'))) { ?>
						<div class="help-block with-errors text-danger">
							<?= form_error('desc'); ?>
						</div>
					<?php } ?>
				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-primary">Submit</button>
					<a href="<?= base_url("admin/restaurants/coin-offers/") ?><?= $coins->restaurant_id ?>">
						<button type="button" class="btn btn-basic">Return</button>
					</a>
				</div>

			</form>
		</div>
	</div>
</div>

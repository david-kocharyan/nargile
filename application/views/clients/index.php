<!--page content-->
<div class="row">
	<div class="col-sm-12">
		<div class="white-box">
			<h3 class="box-title m-b-0">Clients Table</h3>
			<p class="text-muted m-b-30">All clients in 1 place!!</p>
			<div class="table-responsive">
				<table id="myTable" class="table table-striped">
					<thead>
					<tr>
						<th>ID</th>
						<th>Username</th>
						<th>Full Name</th>
						<th>Email</th>
						<th>Role</th>
						<th>Logo</th>
						<th>Active</th>
						<th>Options</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($clients as $key => $value) { ?>
						<tr>
							<td><?= $key + 1 ?></td>
							<td><?= $value->username; ?></td>
							<td><?= $value->full_name; ?></td>
							<td><?= $value->email; ?></td>
							<td><?= $value->role; ?></td>
							<td><?= $value->logo; ?></td>
							<td><?= $value->active; ?></td>
							<td>
								<a href="<?= base_url("admin/clients/edit/$value->id") ?>" data-toggle="tooltip"
								   data-placement="top" title="Edit" class="btn btn-info btn-circle tooltip-info"> <i
										class="fas fa-pencil-alt"></i> </a>
								<?php if ($value->active == 1) { ?>
									<a href="<?= base_url("admin/clients/change-status/$value->id") ?>" data-toggle="tooltip"
									   data-placement="top" title="Deactivate"
									   class="btn btn-danger btn-circle tooltip-danger"><i class="fa fa-power-off"></i></a>
								<?php } else { ?>
									<a href="<?= base_url("admin/clients/change-status/$value->id") ?>" data-toggle="tooltip"
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
































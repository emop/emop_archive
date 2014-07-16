<?php V("/template/header.php") ?>
<div>
	<div>
		<h2>方案配置</h1>
	</div>
</div>
<hr />
<div>
	<table class="table table-bordered">
		<thead>
			<tr>
				<td width="6%">方案id</td>
				<td width="10%">方案名字</td>
				<td width="7%">所属类目</td>
				<td width="10%">适用公众号</td>
				<td width="10%">适用店铺</td>
				<td width="20%">方案描述</td>
				<td width="15%">scheme_path</td>
				<td width="7%">发行状态</td>
				<td width="15%">操作</td>
			</tr>
		</thead>
		<tbody>
		<?php foreach ( $data as $scheme){?>
			<tr logo="<?=$scheme["logo"] ?>">
				<td><span class="scheme_id"><?=$scheme["scheme_id"] ?></span></td>
				<td><span class="name"><?=$scheme["name"] ?></span></td>
				<td><span class="keyword"><?=$scheme["keyword"] ?></span></td>
				<td><span class="wx_level"><?=$scheme["wx_level"] ?></span></td>
				<td><span class="level"><?=$scheme["level"] ?></span></td>
				<td><span class="description"><?=$scheme["description"] ?></span></td>
				<td><span class="scheme_path"><?=$scheme["scheme_path"] ?></span></td>
				<td><span class="status">
				<?php switch ($scheme['status']) {
					case "-1" : echo "开发中"; $btn="发行";break;
					case "1" : echo "发行中";$btn="暂停发行";break;
					case "2" : echo "编辑中"; $btn="发行";break;
					default: echo "状态异常"; $btn="发行";break;
				}
				
				
				?>
				
				</span></td>
				<td>
					<a class="btn btn-primary publication"><?=$btn ?></a>
					<?php if($scheme["status"] != "-1"){?>
						<a class="btn btn-info update">更新</a>
					<?php }?>
				</td>
			</tr>
		<?php }?>
		</tbody>
	</table>
</div>
<?php V("/template/footer.php")?>

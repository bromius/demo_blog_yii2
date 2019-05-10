<div class="modal fade js-modal-post-edit">
	<form enctype="application/x-www-form-urlencoded">
		<div class="modal-dialog">
			<div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Публикация</h4>
                </div>
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label" for="post_title">Заголовок</label>
						<input class="form-control" type="text" id="post_title" name="title" placeholder="Максимум 100 символов" required />
					</div>
					<div class="form-group">
						<label class="control-label" for="post_content">Описание</label>
						<textarea class="form-control" id="post_content" name="content" placeholder="Максимум 1000 символов" rows="5" required></textarea>
					</div>
					<div class="form-group">
						<label class="control-label" for="post_img">Изображение</label>
						<div class="clearfix"></div>
						<input type="file" id="post_img" name="img" />
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Сохранить</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				</div>
			</div>
		</div>
		<input type="hidden" name="id" />
	</form>
</div>
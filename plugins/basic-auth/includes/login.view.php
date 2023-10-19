<form method="POST">
	<input type="text" value="<?=old_value('email', 'jhondoe@gmail.com')?>" name="email"><br>
	<input type="text" value="<?=old_value('password', 'password')?>" name="password"><br>
	<br>
	<select name="gender">
		<option value="">--Select--</option>
		<option <?=old_select('gender', 'male')?> value="male">male</option>
		<option <?=old_select('gender', 'female')?> value="female">female</option>
	</select>
	<br>
	<input <?=old_checked('hello','yes')?> type ="checkbox" name="hello" value="yes"><br>
	<input <?=old_checked('hello2','no')?> type ="checkbox" name="hello2" value="no">
	<br>
	<button>Submit</button>
</form>

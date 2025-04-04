function previewImage(event)
{
	const reader = new FileReader();
	reader.onload = function ()
	{
		const output = document.getElementById('imagePreview');
		output.src = reader.result;
	};
	reader.readAsDataURL(event.target.files[0]);
}

export const validate = (event: KeyboardEvent, min: number, max: number) => {
    const inputElement = event.target as HTMLInputElement;
    if (inputElement && inputElement.value.length >= inputElement.size) {
        const newValue = inputElement.value + event.key;
        if (parseInt(newValue) > max || parseInt(newValue) < min) {
            inputElement.setCustomValidity(t('form.not_allowed'));
            event.preventDefault();
        }
        else {
            inputElement.setCustomValidity('');
        }
        inputElement.reportValidity();
    } else {
        inputElement.setCustomValidity('');
        inputElement.reportValidity();
    }
}
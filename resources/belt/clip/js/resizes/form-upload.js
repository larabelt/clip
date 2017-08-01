import BaseForm from 'belt/clip/js/resizes/form';

class Form extends BaseForm {

    /**
     * Reset the form fields.
     */
    reset() {
        super.reset();
        this.hasFile = true;
    }

}

export default Form;
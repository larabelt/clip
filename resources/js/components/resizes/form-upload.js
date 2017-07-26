import BaseForm from 'belt/clip/js/components/resizes/form';

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
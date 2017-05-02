import BaseForm from './form';

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
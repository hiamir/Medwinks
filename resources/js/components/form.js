document.addEventListener('alpine:init', function () {
    Alpine.data('Form', (data) => ({
        'wireModel': data.wireModel,
        'label': data.label,
        'inputData': data.inputData,
        'xmodel':data.xmodel,
        'errors': data.errors,
        'livName': data.livName,
        'type': data.type,
        'resetInput': false,
        'isDate': false,
        'placeholder': data.placeholder,
        'disabled': data.disabled,
        'value': data.value,
        'dateConfig': data.dateConfig,
        'errorCount': data.errorCount,

        init() {
            Alpine.effect(() => {

            });
        }
    }));

    window.Alpine.bind('input', (data) => ({
        type: data.type,
        placeholder: data.placeholder,
        class: 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',

        // ':x-model'() {
        //     return this.name;
        // },

        '@change'() {
            this.date_of_birth = this.$refs.input.value
        },

        // ':x-ref'() {
        //     ((this.$el.type === 'date') ? this.isDate = true : this.isDate = false)
        //     return ((this.$el.type === 'date') ? 'inputDate' : 'input')
        // },

        // ':type'() {
        //     ((this.$el.type === 'date') ? this.isDate = true : this.isDate = false)
        //     if (this.$el.type === 'date') {
        //
        //     }
        //     return 'text';
        // },

        ':init'() {
            ((this.$el.type === 'date') ? this.isDate = true : this.isDate = false)
            if (this.$el.type === 'date') {
                flatpickr(this.$refs.input, this.dateConfig)
                this.resetInput = true
            }

            return true;
        },

        ':value'() {
            return ((this.errorCount === 0) ? this.value.alpineValue : this.value.livewireValue);
        }
    }));
});

document.addEventListener('alpine:init', function () {
    Alpine.data('Main', ($wire, data) => ({
        isUserManager: data.isUserManager,
        openModal: false,
        openDecisionModal: false,
        RoleMenuToggle: false,
        PasswordResetModal: {},
        LoginModal: {},
        isHeaderMenuOpen: false,
        AddUpdateModal: {},
        AccessDeniedModal: {},
        ConfirmationModal: {},
        RequirementModal: {},

        ChatModal: {},
        PhotoViewModal: {},
        ErrorModal: {},
        DeleteModal: {},
        SuccessModal: {},
        model: null,
        modalSize: 'medium',
        modalType: null,
        modalHeader: null,
        modalSubmitName: null,
        toast: {},
        toastShow: null,
        dataRecord: {},
        error: {},
        errorCount: 0,
        recordName: null,
        modalName: null,
        modalText: '',
        success: null,
        toggle: false,
        result: [],
        finalResult: [],
        isExists: null,
        classes: {},
        modalDetails: '',
        setDocumentID: data.setDocumentID,
        validationErrors: {},

        init() {

            this.openModal = false;
            this.openDecisionModal = false;
            this.PasswordResetModal = {'show': false, 'title': '', 'message': ''};
            this.LoginModal = {'show': false, 'formType': '', 'type': '', 'size': '', 'title': '', 'submit': ''};
            this.isHeaderMenuOpen = false;
            this.RoleMenuToggle = false;

            this.AddUpdateModal = {'show': false, 'formType': '', 'size': '', 'title': '', 'submit': ''};
            this.AccessDeniedModal = {'show': false, 'message': ''};
            this.PhotoViewModal = {'show': false, 'message': ''};
            this.ErrorModal = {'show': false, 'formType': '', 'type': '', 'size': '', 'title': '', 'submit': ''};
            this.DeleteModal = {'show': false, 'title': '', 'message': ''};
            this.SuccessModal = {'show': false, 'title': '', 'message': ''};
            this.ConfirmationModal = {'show': false, 'type': '', 'title': '', 'message': ''};
            this.ChatModal = {'show': false, 'title': ''};
            this.RequirementModal = {'show': false, 'title': '', 'message': ''};
            this.model = null;
            this.modalSize = 'medium';
            this.modalType = null;
            this.modalHeader = null;
            this.modalSubmitName = null;
            this.toast = {'alert': '', 'message': ''};
            this.toastShow = null;
            this.dataRecord = {};
            this.error = {};
            this.errorCount = 0;
            this.recordName = null;
            this.modalName = null;
            this.modalText = '';
            this.success = null
            this.toggle = false;
            this.result = [];
            this.finalResult = [];
            this.isExists = null;
            this.modalDetails = $wire.modalDetails;
            this.validationErrors = $wire.entangle('validationErrors');

            this.classes = {
                'input': 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
                'inputDate': 'cursor-pointer bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
                'textarea': 'block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
                'select': 'cursor-pointer relative bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
                'file': 'hidden block w-full text-xs text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400',
                'checkbox': 'w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600'
            }

        },
        CloseOtherModals() {
            this.RequirementModal.show = false;
        },

        check(id, obj) {
        }
        ,

        twoDigitNumber(n) {
            return n > 9 ? "" + n : "0" + n;
        },

        compareArrays(array1, array2) {
            // Check length of both arrays
            // if length not equal then arrays are different
            if (array2.length === 0)
                return false;
            else {
                let exists = 0;
                let doesntExists = 0;
                // check every element of the two arrays
                for (let i = 0; i < array1.length; i++) {
                    for (let j = 0; j < array2.length; j++) {
                        if (array1[i] === array2[j]) {

                            exists++
                        } else {
                            doesntExists++
                        }
                    }
                }

// console.log('Exists:'+exists);
// console.log('Doesnt Exists:'+doesntExists);

                if (exists > 0) {
                    return false;
                } else if (doesntExists > 0) {
                    return true;
                }
                // return true;
            }
        },

        checkNumber(e) {
            let validkeys = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
            return (validkeys.indexOf(e.key) > 0);
        },

        fileExtension(filename, path = null) {
            if (path !== null) {
                if (filename !== undefined && this.checkFileExist(path, filename)) {
                    const a = filename.split(".");
                    let b = a.pop().split('?')[0];
                    // if( a.length === 1 || ( a[0] === "" && a.length === 2 ) ) {
                    //     return "";
                    // }

                    return b;
                }
            } else {
                if (filename !== undefined || filename !== '') {
                    const a = filename.split(".");
                    let b = a.pop().split('?')[0];
                    // if( a.length === 1 || ( a[0] === "" && a.length === 2 ) ) {
                    //     return "";
                    // }
                    return b;
                }
            }
        },

        checkFileExist(path, filename) {
            let fileLink;
            if (filename !== undefined && filename.length > 0) {
                fileLink = path + filename;
                console.log(fileLink);
                var xhr = new XMLHttpRequest();
                xhr.ontimeout = () => {
                    console.error(`The request for ${url} timed out.`);
                };

                xhr.open('HEAD', fileLink, true);
                xhr.send();
                if (xhr.status === "404") {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false
            }

        },

        checkImage(filename) {
            if (filename !== undefined || filename !== '') {
                const imgExt = ['png', 'svg', 'jpg', 'jpeg', 'gif'];
                const ext = this.fileExtension(filename)
                return (imgExt.includes(ext))
            }

        },

        //
        // check(id,fileName) {
        //
        //     this.checkIfImageExists(fileName, (exists) => {
        //         if (exists) {
        //             this.result[id] = {'id':id,'show':true}
        //
        //         } else {
        //             this.result[id] = {'id':id,'show':false}
        //         }
        //     });
        //     console.log(this.result)
        //     return this.result;
        // },
        momentDate(myDate) {
            return myDate.split(' ')[0];
        },

        checkIfImageExists(id, url) {
            const img = new Image();
            img.src = url;
            this.isExists = null;
            if (img.complete) {
                this.result.push({'id': id, 'show': true});
                this.isExists = true;
                console.log('Complete: Image Exists!');

            } else {
                img.onload = () => {
                    // callback(true);
                    this.result.push({'id': id, 'show': true});
                    this.isExists = true;
                    console.log('Load: Image Exists!');
                };

                img.onerror = () => {
                    console.log('Error: Image does not Exists!');
                    this.result.push({'id': id, 'show': false});
                    this.isExists = false;
                    // callback(false);
                };
            }
        }
        ,

        clearFields() {
            let elements = document.getElementsByTagName("input");
            for (let ii = 0; ii < elements.length; ii++) {
                if (elements[ii].type === "text") {
                    elements[ii].value = "";
                }
            }
        }
        ,

        addModalExecute() {
            switch (this.model) {
                case 'permission':
                    switch (this.modalDetails['formType']) {
                        case 'permission':
                            this.AddUpdateModal.title = 'Add permission';
                            break;
                    }
                    break;
                case 'gender':
                    switch (this.modalDetails['formType']) {
                        case 'gender':
                            this.AddUpdateModal.title = 'Add gender';
                            break;

                        case 'defaultProfilePhoto':
                            this.AddUpdateModal.title = 'Add default photo';
                            break;
                    }
                    break;

                case 'country':
                    switch (this.modalDetails['formType']) {
                        case 'country':
                            this.AddUpdateModal.title = 'Add Country';
                            break;

                        case 'region':
                            this.AddUpdateModal.title = 'Add Region';
                            break;
                    }
                    break;

                case 'qualification':
                    switch (this.modalDetails['formType']) {
                        case 'qualification':
                            this.AddUpdateModal.title = 'Add qualification';
                            break;
                        case 'degree':
                            this.AddUpdateModal.title = 'Add degree';
                            break;
                    }
                    break;

                case 'service':
                    switch (this.modalDetails['formType']) {
                        case 'service':
                            this.AddUpdateModal.title = 'Add service';
                            break;
                        case 'serviceRequirement':
                            this.AddUpdateModal.title = 'Add service requirement';
                            break;
                    }
                    break;

                case 'service-requirement':
                    switch (this.modalDetails['formType']) {
                        case 'service-requirement':
                            this.AddUpdateModal.title = 'Add service requirement';
                            break;
                    }
                    break;

                case 'passport':
                    switch (this.modalDetails['formType']) {
                        case 'passport':
                            this.AddUpdateModal.title = 'Add passport';
                            break;
                    }
                    break;

                case 'document':
                case 'client-details':
                    switch (this.modalDetails['formType']) {
                        case 'document':
                        case 'client-details':
                            this.AddUpdateModal.title = 'Add document';
                            break;
                        case 'passport':
                            this.AddUpdateModal.title = 'Add passport';
                            break;
                    }
                    break;


                default:
                    this.AddUpdateModal.title = 'Add user';
            }
            this.AddUpdateModal.show = true;
            this.AddUpdateModal.submit = 'Add';
        }
        ,

        updateModalExecute(record = null, isModal = true) {

            if (record != null) {

                switch (this.model) {
                    case 'profile':
                        switch (this.modalDetails['formType']) {
                            case 'password-change':
                                this.LoginModal.size = 'medium';
                                this.LoginModal.type = 'update';
                                break;
                        }
                        break;

                    case 'qualification':
                        switch (this.modalDetails['formType']) {
                            case 'qualification':
                                break;
                            case 'degree':
                                break;
                        }
                        break;
                    case 'passport':
                        switch (this.modalDetails['formType']) {
                            case 'update':
                                break;

                        }
                        break;
                }

                this.AddUpdateModal.show = isModal;
                if (this.model === 'passport') {

                    this.AddUpdateModal.title = 'Update ' + this.dataRecord.given_name;
                    this.AddUpdateModal.submit = 'Update ' + this.dataRecord.given_name;
                } else if (this.model === 'client-details') {
                    if (this.modalDetails['formType'] === 'passport') {
                        this.AddUpdateModal.title = 'Update ' + this.dataRecord.given_name;
                        this.AddUpdateModal.submit = 'Update ' + this.dataRecord.given_name;
                    } else if (this.modalDetails['formType'] === 'document') {
                        this.AddUpdateModal.title = 'Update ' + this.dataRecord.name;
                        this.AddUpdateModal.submit = 'Update ' + this.dataRecord.name;
                    }
                } else {
                    console.log(this.dataRecord.name);
                    this.AddUpdateModal.title = 'Update ' + this.dataRecord.name;
                    this.AddUpdateModal.submit = 'Update ' + this.dataRecord.name;
                }


            }
        }
        ,

        deleteModalExecute(record = null) {
            let name = '', title = '', msg = '';

            if (record != null) {

                this.DeleteModal.show = true;
                switch (this.model) {
                    case 'passport':
                        title = record.passport_number;
                        name = record.passport_number;
                        break;

                    case 'service':
                        switch (this.modalDetails['formType']) {
                            case 'service':
                                title = record.name;
                                name = record.name + '.';
                                msg = 'All the requirements attached will be deleted as well!';
                                break;
                        }
                        break;
                    default:
                        name = record.name;
                        break;
                }
                this.DeleteModal.title = 'Delete ' + title + '?'
                this.DeleteModal.message = '<div class="flex flex-col justify-center items-center"><span class="flex">Are you sure you want to delete </span> <span class="flex font-bold"> "' + name + '"</spanclass>?</span> <span> ' + msg + '</span><div>'
            }
        },

        confirmationModalExecute(record = null) {
            let name = '', title = '', msg = '';

            name = record.name;
            this.ConfirmationModal.title = 'Delete ' + title + '?'
            this.ConfirmationModal.message = '<div class="flex flex-col justify-center items-center"><span class="flex" x-text="msg"></span><div>'
        },

        chatModalExecute(record = null) {
            let name = '', title = '', msg = '';

            name = record.name;
            this.ChatModal.title = 'Chat History ' + title + '?'
            this.ChatModal.message = '<div class="flex flex-col justify-center items-center"><span class="flex" x-text="msg"></span><div>'
        },

        resetPasswordModalExecute(record = null) {
            if (record != null) {
                this.PasswordResetModal.show = true;
                this.PasswordResetModal.title = "Reset Password";
                this.PasswordResetModal.message = 'Are you sure you want to reset password for ' + this.dataRecord.name + '?';
            }
        },


        MyModal(type, formType = null, record = {}) {
            if (record != null) {
                this.errorCount = 0;

                this.validationErrors = {};
                this.model = this.modalDetails['model'];

                this.modalType = type;
                this.modalDetails = {
                    'model': this.model,
                    'formType': formType,
                    'modalType': type,
                    'record': record
                };


                $wire.emit('myController', this.modalDetails);

                if (type === 'add') {
                    this.clearFields();
                    this.dataRecord = {};
                }

                if (this.dataRecord != null) {
                    this.dataRecord = record.formData;
                    switch (this.modalDetails['model']) {
                        case'passport':
                            if (type === 'update' || type === 'delete') this.recordName = record.formData.passport_number;
                            break;
                        default:
                            if (type === 'update' || type === 'delete' || type === 'password-reset') this.recordName = record.formData.name;
                            break;
                    }

                }

                // if (type === 'add' || type === 'update') this.AddUpdateModal = {
                //     'show': true,
                //     'formType': formType,
                //     'size': '',
                //     'type': type,
                //     'title': '',
                //     'submit': ''
                // }
                // if (type === 'delete') this.DeleteModal(this.dataRecord)
                if (type === 'password-reset') this.PasswordResetModal = {'show': true, 'title': '', 'message': ''};


                switch (this.model) {

                    // CHECK FORM TYPE IS ADMIN
                    case 'administrator':
                    case 'user':
                    case 'gender':
                    case 'profile':
                    case 'defaultProfilePhoto':
                    case 'country':
                    case 'region':
                    case 'role':
                    case 'permission':
                    case 'menu':
                    case 'menu-items':
                    case 'qualification':
                    case 'degree':
                    case 'university':
                    case 'passport':
                    case 'service':
                    case 'service-requirement':
                    case 'document':
                    case 'client-details':
                        this.AddUpdateModal.size = 'medium';

                        switch (this.model) {
                            case 'country':
                            case 'passport':
                                this.AddUpdateModal.size = 'large';
                                break;

                            case 'client-details':
                                if (this.modalDetails.formType === 'passport') {
                                    this.AddUpdateModal.size = 'large';
                                }
                                break;
                        }
                        switch (type) {
                            case 'add':
                                this.addModalExecute(this.dataRecord)
                                break;

                            case 'update':
                            case 'password-change':
                            case 'roleToggle':
                                (this.model === 'profile') ? this.updateModalExecute(this.dataRecord, false) : this.updateModalExecute(this.dataRecord, true);
                                break;


                            case 'delete':

                                this.deleteModalExecute(this.dataRecord)
                                break;

                            case 'password-reset':
                                this.resetPasswordModalExecute(this.dataRecord)
                                break;
                        }
                }

            }
            this.eventToListen();
        }
        ,


        eventToListen() {
            // EVENT LISTENER TO CLOSE THE MODAL

            window.addEventListener('login-modal', event => {
                let message = 'Authentication Required±';
                (event.detail.message === '') ? this.LoginModal = {
                    'show': event.detail.show,
                    'message': message
                } : this.LoginModal = {
                    'show': event.detail.show,
                    'title': 'Authentication',
                    'formType': '',
                    'type': 'security',
                    'size': 'medium',
                    'submit': ''
                }
            });

            window.addEventListener('my-modal', event => {
                this.MyModal(event.detail.action, event.detail.formType, event.detail.data)
            });


            window.addEventListener('success-modal', event => {
                if (event.detail.show === true) {
                    this.AddUpdateModal.show = false;
                    this.DeleteModal.show = false;
                    this.ConfirmationModal.show = false;
                    this.ChatModal.show = false;
                }
                this.SuccessModal = {
                    'show': event.detail.show,
                    'title': event.detail.title,
                    'message': event.detail.message,
                }
            });


            window.addEventListener('error-modal', event => {
                if (event.detail.show === true) {
                    this.AddUpdateModal.show = false;
                    this.DeleteModal.show = false;
                }
                this.ErrorModal = {
                    'show': event.detail.show,
                    'type': event.detail.type,
                    'title': event.detail.title,
                    'message': event.detail.message,
                }
            });

            window.addEventListener('add-update-modal', event => {
                let message = 'Are you sure you want to reset password?';
                (event.detail.message === '') ? this.AddUpdateModal = {
                    'show': event.detail.show,
                    'message': message
                } : this.AddUpdateModal = {'show': event.detail.show, 'message': event.detail.message}
            });

            window.addEventListener('closeDecisionModal', event => {
                this.openDecisionModal = false;
            });

            window.addEventListener('reset-password-modal', event => {
                let message = 'Are you sure you want to reset password?';
                (event.detail.message === '') ? this.PasswordResetModal = {
                    'show': event.detail.show,
                    'message': message
                } : this.PasswordResetModal = {'show': event.detail.show, 'message': event.detail.message}
            });

            window.addEventListener('delete-modal', event => {

                let message = 'Are you sure you want to delete this record?';
                (event.detail.message === '') ? this.DeleteModal = {
                    'show': event.detail.show,
                    'message': message
                } : this.DeleteModal = {'show': event.detail.show, 'message': event.detail.message}
            });

            window.addEventListener('success-modal', event => {
                let message = 'The action is successful!';
                (event.detail.message === '') ? this.SuccessModal = {
                    'show': event.detail.show,
                    'title': event.detail.title,
                    'message': message
                } : this.SuccessModal = {
                    'show': event.detail.show,
                    'title': event.detail.title,
                    'message': event.detail.message
                }
            });

            // window.addEventListener('my-modal', event => {
            //
            //     let message = 'Are you sure you want to delete this record?';
            //     (event.detail.message === '') ? this.DeleteModal = {
            //         'show': event.detail.show,
            //         'message': message
            //     } : this.DeleteModal = {'show': event.detail.show, 'message': event.detail.message}
            // });

            window.addEventListener('confirmation-modal', event => {

                let message = 'Are you sure you want to perform this action?';
                (event.detail.message === '') ? this.ConfirmationModal = {
                    'show': event.detail.show,
                    'type': event.detail.type,
                    'title': event.detail.title,
                    'message': message
                } : this.ConfirmationModal = {
                    'show': event.detail.show,
                    'type': event.detail.type,
                    'title': event.detail.title,
                    'message': event.detail.message
                }
            });

            window.addEventListener('chat-modal', event => {
                this.ChatModal = {
                    'show': event.detail.show,
                    'title': event.detail.title,

                }
            });

            window.addEventListener('requirement-modal', event => {
                this.RequirementModal = {
                    'show': event.detail.show,
                    'title': event.detail.title,
                    'message': event.detail.message
                }
            });

            window.addEventListener('access-denied-modal', event => {
                this.toggle = !this.toggle;
                if (event.detail.show === true) this.success = false;
                let message = 'You do not have permissions to access this page!';
                (event.detail.message === '') ? this.AccessDeniedModal = {
                    'show': event.detail.show,
                    'message': message
                } : this.AccessDeniedModal = {'show': event.detail.show, 'message': event.detail.message}
            });

            window.addEventListener('photo-view-modal', event => {
                this.toggle = !this.toggle;
                if (event.detail.show === true) this.success = false;
                let message = 'You do not have permissions to access this page!';
                (event.detail.message === '') ? this.PhotoViewModal = {
                    'show': event.detail.show,
                    'message': message
                } : this.PhotoViewModal = {'show': event.detail.show, 'message': event.detail.message}
            });

            window.addEventListener('toast', toast => {
                this.toastShow = true;
                this.toast.alert = toast.detail.alert;
                this.toast.message = toast.detail.message;
            });
        }
        ,
    }));
});

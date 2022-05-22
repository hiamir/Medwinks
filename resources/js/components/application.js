import moment from "moment/moment";
import isArray from "alpinejs";

document.addEventListener('alpine:init', function () {

    Alpine.data('Application', ($wire, data) => ({
        records: data.records,
        application: $wire.entangle('application'),
        passport: data.passport,
        services: data.services,
        selectedDocuments: $wire.entangle('selectedDocuments'),
        serviceRequirements: $wire.entangle('serviceRequirements'),
        stepID: $wire.entangle('step'),
        serviceName: $wire.entangle('serviceName'),
        passportID: $wire.entangle('application.passportID'),
        serviceID: $wire.entangle('application.serviceID'),
        serviceRequirementID: $wire.entangle('serviceRequirementID'),
        serviceRequirementsCount: $wire.entangle('serviceRequirementsCount'),
        universityID: $wire.entangle('application.universityID'),
        universities: $wire.universities,
        qualifications: $wire.qualifications,
        qualificationID: $wire.entangle('application.qualificationID'),
        degreeData: $wire.entangle('degreeData'),
        degreeID: $wire.entangle('application.degreeID'),

        documents: [],
        rejectCheckbox: $wire.entangle('rejectCheckbox'),
        isSubmitting: false,
        progress: 0,
        error: false,
        find: false,
        recordCount: 0,
        isRecord: false,
        removeIndex: 0,
        steps: [
            {'id': 1, 'title': 'Information'},
            {'id': 2, 'title': 'Passport'},
            {'id': 3, 'title': 'University'},
            {'id': 4, 'title': 'Qualification'},
            {'id': 5, 'title': 'Service'},
            {'id': 6, 'title': 'Documents'},
            {'id': 7, 'title': 'Finish'},

        ],

        addDocument(requirementID, documentID) {
            // console.log('Requirmenet: ' + this.findRequirement(requirementID));
            if (this.findRequirement(requirementID)) this.deleteDocumentID(requirementID)
            this.selectedDocuments.push({'id': requirementID, did: documentID});
        },

        deleteDocumentID(requirementID) {
            this.removeIndex = this.selectedDocuments.map(function (item) {
                return item.id;
            }).indexOf(requirementID);
            this.selectedDocuments.splice(this.removeIndex, 1);
        },

        findRequirement(requirementID) {
            return this.selectedDocuments.some(function (el) {
                return (el.id === requirementID);
            });
        },

        findDocument(requirementID, documentID) {
            return this.selectedDocuments.some(function (el) {
                return (el.id === requirementID && el.did === documentID);
            });
        },

        bindUniversity: {
            ['x-model']: 'universityID',
            ['name']: 'University',


            ':class'() {
                return this.classes.select;
            },
        },

        university() {
            return {
                'name': 'university',
                'label': 'Tell us about your University',

                'livewireName': 'application.applicationID',
                'placeholder': 'Choose your university',
                'options': this.universities,
            }
        },


        bindQualification: {
            ['x-model']: 'qualificationID',
            ['name']: 'Qualification',

            ':class'() {
                return this.classes.select;
            },
        },

        qualification() {
            return {
                'name': 'qualification',
                'label': 'Tell us about your qualification',

                'livewireName': 'qualificationID',
                'placeholder': 'Choose your qualification',
                'options': this.qualifications,
            }
        },

        bindDegree: {
            ['x-model']: 'degreeID',
            ['name']: 'Degree',

            ':class'() {
                return this.classes.select;
            },
        },

        degree() {
            return {
                'name': 'degree',
                'label': 'Tell us about your specialization',

                'livewireName': 'degreeID',
                'placeholder': 'Choose your specialization',
                'options': $wire.entangle('degreeData'),
            }
        },


        imageShow: {
            ':src'() {
                if (this.modalDetails.modalType !== 'add') {
                    let path = '';

                    (this.isFileExists) ? path = '/' + this.path + '?ver=' + Math.floor((Math.random() * 100) + 1) : path = '/storage/images/documents/not-found.jpg';
                    // console.log(path);
                    return path;
                } else {
                    return '';
                }

            },
            ':class'() {
                return "w-16 h-16 border-2 border-gray-100"
            }
        },


        documentFile() {
            return {
                submitName: 'Upload',
                isUploading: false,
                progress: 0,
                isSubmitButton: false,
                label: 'Document file',
                pFile: $wire.entangle('document.file'),

                livewireName: 'document.file',
                placeholder: 'Upload the file (jpg,png,jpeg,gif,svg)',
            }
        },


        init() {
            Alpine.effect(() => {

                this.progress = ((100 / this.steps.length) * this.steps[this.stepID - 1].id);
                if (Object.keys(this.degreeData).length > 0) {
                    if (this.application.qualificationID !== "") {
                        this.recordCount = Object.keys(this.degreeData).length;
                        if (this.recordCount) this.isRecord = true;
                    } else {
                        this.isRecord = false;
                    }
                }
                this.submit = false;


                switch (this.stepID) {
                    case 1:
                        this.error = false;
                        this.isSubmitting = false;
                        (Object.entries(this.passport).length > 0 && Object.entries(this.services).length > 0) ? this.error = false : this.error = true;
                        // console.log(this.services)
                        break;

                    case 2:

                        ((this.passportID !== undefined && this.passportID !== null)) ? ((moment(this.passport.expiry_date).isBefore(moment()) || this.passport === '') ? this.error = true : this.error = false) : this.error = true;
                        break;

                    case 3:
                        this.isRecord = false;
                        this.recordCount = 0;
                        (this.application.universityID !== "") ? this.error = false : this.error = true;
                        break;

                    case 4:
                        this.isRecord = false;
                        this.recordCount = 0;
                        (this.degreeID !== "") ? this.error = false : this.error = true;
                        // console.log('e:' + this.error);
                        break;

                    case 5:
                        // console.log('s:' + this.serviceID);
                        this.selectedDocuments = [];
                        this.application.documents = [];
                        this.serviceRequirementID = null;
                        this.application.serviceID = this.serviceID;
                        (this.application.serviceID !== "") ? this.error = false : this.error = true;
                        break;

                    case 6:
                        // console.log(this.serviceRequirements.length);
                        // console.log(this.selectedDocuments.length);

                        this.selectedDocuments = this.application.documents;
                        (this.selectedDocuments.length === this.serviceRequirements.length) ? this.error = false : this.error = true;
                        break;

                    case 7:
                        (((this.passport !== undefined) && (this.serviceID !== null) && (this.selectedDocuments.length === this.serviceRequirements.length))) ? this.error = false : this.error = true;
                        // console.log(this.error);
                        break;
                }

            });
        },


    }))


});

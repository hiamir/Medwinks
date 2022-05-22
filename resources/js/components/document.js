import moment from "moment/moment";
import Dropzone from "dropzone";

let fpDob = '', fpIssue = '', fpExpiry = '', passport;

document.addEventListener('alpine:init', function () {

    Alpine.data('Document', ($wire, data) => ({
        fileID:'document-dropzone-file',
        user: {},
        documents: {},
        // passports: {},
        activeStart: false,
        documentRecord: {},
        documentSelected: {},
        // passportSelected: {},
        profileMenuToggle: false,
        applications: $wire.applications,
        // requirementData: $wire.requirement,
        documentType: $wire.entangle('documentType').defer,
        documentID: data.documentID,

        isRecord: false,
        recordCount: 0,
        documentToggle: null,
        isSubmitting: false,
        submitClick: false,
        documentShow: false,
        records: [],
        countries: [],
        allRegions: [],
        documentFileLength: 0,
        // regions: $wire.entangle('regions'),
        // passportID: null,
        fileValidationError: '',
        isAdditionalDocuments: false,
        valueDob: null,

        isFileExists: $wire.entangle('document.isFileExists'),
        path: $wire.entangle('path'),
        tempName: $wire.entangle('tempName'),
        tempUrl: $wire.entangle('tempUrl'),
        // requirement: $wire.entangle('document.service_requirement_id').defer,
        documentNotes: $wire.entangle('document.notes').defer,
        documentName: $wire.entangle('document.name').defer,
        documentRequirement: $wire.entangle('document.service_requirement_id').defer,
        documentFile: $wire.entangle('document.file'),
        // documentType: $wire.entangle('confirmationType').defer,
        confirmationType: $wire.entangle('confirmationType').defer,
        file: $wire.entangle('document.file').defer,
        validationErrors: $wire.entangle('validationErrors'),
        requirementTabID: $wire.entangle('requirementTabID'),
        userID: $wire.entangle('userID'),
        comments: $wire.entangle('comments').defer,
        chats: $wire.entangle('chats'),
        isPermission: $wire.entangle('isPermission'),
        requirements: $wire.entangle('requirements'),
        documentSelectedFile: '',
        documentSelectedName: '',
        rejectCheckbox:false,

        canDocumentUpdate: $wire.checkPermission('user-document-update'),
        // rejectCheckbox: $wire.entangle('rejectCheckbox'),
        // confirmationModalData: $wire.entangle('confirmationModalData'),
        // additionalRequirements: $wire.entangle('additionalRequirements'),
        // selectedRequirements: $wire.entangle('selectedRequirements'),
        // dobFlatpickr: '',


        bindDocumentName: {
            ['x-model']: 'documentName',
            ['id']: 'name',
            ['name']: 'name',
            ['type']: 'text',
            ['placeholder']: 'Enter your given name',
        },


        bindDocumentNotes: {
            ['x-model']: 'documentNotes',
            ['id']: 'notes',
            ['name']: 'notes',
            ['rows']: 4,
            ['placeholder']: 'Enter Notes',
        },

        bindDocumentRequirement: {
            ['x-model']: 'documentRequirement',
            ['id']: 'document_requirement',
            ['name']: 'document_requirement',
        },

        // imageShow: {
        //     ':src'() {
        //         if (this.modalDetails.modalType !== 'add') {
        //             let path = '';
        //             (this.isFileExists) ? path = '/' + this.path + '?ver=' + Math.floor((Math.random() * 100) + 1) : path = '/storage/images/not-found.jpg';
        //             // console.log(path);
        //             return path;
        //         } else {
        //             return '';
        //         }
        //
        //     },
        //     ':class'() {
        //         return "w-16 h-16 border-2 border-gray-100"
        //     }
        // },

        bindDocumentFile: {
            ['x-model']: 'documentFile',
            ['name']: 'document_file',
        },

        bindComments: {
            ['x-model']: 'comments',
            ['name']: 'Comments',
            ['rows']: 4,
            ['placeholder']: 'Enter Comments',

            ':class'() {
                return this.classes.textarea;
            },
        },

        checkFile(file) {
            if(file === undefined){
                this.isFile=false;
            }else{
                this.isFile=true;
            }
        },

        commentsData() {
            return {
                'label': 'Comments',
                'livewireName': 'comments',
            }
        },


        init() {
            Alpine.effect(() => {
                //     if(!this.AddUpdateModal.show){
                //         this.passportDOB='';
                //         this.passportSelected={};
                //     }
                //
                //     if(this.documentSelected.file !==undefined) console.log(this.fileExtension(this.documentSelected.file))

                this.fileValidationError = this.validationErrors['document.file'];
                // console.log(this.fileValidationError);
                if (this.documentSelected.id !== undefined) {

                    this.documentName = this.documentSelected.name;
                    this.documentNotes = this.documentSelected.notes;
                    this.documentRequirement = this.documentSelected.service_requirement_id;
                    // this.documentFile = this.documentSelected.file;
                    //     this.passportGivenName = this.passportSelected.given_name;
                    //     this.passportSurName = this.passportSelected.passport_number;
                    //     this.passportID = this.passportSelected.id;
                    //     this.countryID = this.passportSelected.countries_id;
                    //     this.regionID = this.passportSelected.regions_id;
                    //     this.passportCountry = this.passportSelected.countries_id;
                    //     this.passportRegion = this.passportSelected.regions_id;
                    //     this.passportDOB = this.passportSelected.date_of_birth;
                    //     this.passportIssue = this.passportSelected.issue_date;
                    //     this.passportExpiry = this.passportSelected.expiry_date;
                    //     this.passportFile = this.passportSelected.file;
                    //     this.valueDob = this.passportSelected.date_of_birth
                    //     console.log('countryID: ' + this.countryID);
                }
            });
        },


    }))


});

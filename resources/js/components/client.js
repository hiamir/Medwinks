import moment from "moment/moment";

let fpDob = '', fpIssue = '', fpExpiry = '', passport;

document.addEventListener('alpine:init', function () {

    Alpine.data('Client', ($wire, data) => ({
        //
        // user: {},
        // documents: {},
        // // passports: {},
        // activeStart: false,
        // documentRecord: {},
        // documentSelected: {},
        // // passportSelected: {},
        // profileMenuToggle: false,
        // // applications: data.applications,
        // requirementData: $wire.requirement,
        // requirements: data.requirements,
        // documentID: data.documentID,
        clientTab: data.clientTab,
        // isRecord: false,
        // recordCount: 0,
        // documentToggle: null,
        // isSubmitting: false,
        // submitClick: false,
        // documentShow: false,
        // records: [],
        // countries: [],
        // allRegions: [],
        // // regions: $wire.entangle('regions'),
        // // passportID: null,
        //
        // isAdditionalDocuments: false,
        // valueDob: null,
        //
        // isFileExists: $wire.entangle('document.isFileExists'),
        // path: $wire.entangle('path'),
        // tempName: $wire.entangle('tempName'),
        // tempUrl: $wire.entangle('tempUrl'),
        // requirement: $wire.entangle('document.service_requirement_id').defer,
        // notes: $wire.entangle('document.notes').defer,
        // documentName: $wire.entangle('document.name').defer,
        // documentType: $wire.entangle('confirmationType').defer,
        // confirmationType: $wire.entangle('confirmationType').defer,
        // file: $wire.entangle('document.file').defer,
        // validationErrors: $wire.entangle('validationErrors'),
        // requirementTabID: $wire.entangle('requirementTabID'),
        // userID: $wire.entangle('userID'),
        // comments: $wire.entangle('comments').defer,
        // chats: $wire.entangle('chats'),
        isApplicationZone: $wire.entangle('isApplicationZone'),
        universityName: $wire.entangle('universityName'),
        degreeName: $wire.entangle('degreeName'),
        rejectCheckbox: $wire.entangle('rejectCheckbox'),
        // confirmationModalData: $wire.entangle('confirmationModalData'),
        additionalRequirements: $wire.entangle('additionalRequirements'),
        selectedRequirements: $wire.entangle('selectedRequirements'),
        filterRecord:$wire.entangle('filterRecord'),
        //
        // dobFlatpickr: '',


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


        init() {


            Alpine.effect(() => {
                // console.log(this.clientTab);
                // console.log( this.rejectCheckbox);
                (this.clientTab === 'application') ? this.isApplicationZone = true : this.isApplicationZone = false;
            });
        },


    }))


});

import Dropzone from "dropzone";
import moment from "moment/moment";

let fpDob = '', fpIssue = '', fpExpiry = '';
let fpDobInput = document.querySelector("#dob");
let fpIssueInput = document.querySelector("#issue");
let fpDobValue = '';
let shouldIssueClear = false;
let shouldExpireClear = false;


document.addEventListener('alpine:init', function () {

    Alpine.data('Passport', ($wire, data) => ({
        fileID:'passport-dropzone-file',
        rejectCheckbox:false,
        formTangle: {},
        errorCount: null,
        passports: data.passports,
        passportSelected: {},
        issueFlatpickr: {},
        expiryFlatpickr: {},
        dobDate: '',
        issueDate: '',
        expiryDate: '',
        placeholder: '',
        countryData: $wire.countries,
        regionData: $wire.entangle('regions'),
        confirmationType: $wire.entangle('confirmationType').defer,
        isRecord: false,
        recordCount: 0,
        filteredRegions: {},
        tempName: $wire.entangle('tempName'),
        tempUrl: $wire.entangle('tempUrl'),
        documentType: $wire.entangle('documentType').defer,
        countries: [],
        allRegions: $wire.entangle('allRegions'),
        regions: $wire.entangle('regions'),
        passportID: null,
        passport: $wire.entangle('passport'),
        countryID: $wire.entangle('countryID'),
        regionID: $wire.entangle('regionID'),
        dobFlatpickr: '',
        isFileExists: $wire.entangle('passport.isFileExists'),
        passportPassportNumber: $wire.entangle('passport.passport_number').defer,
        passportGivenName: $wire.entangle('passport.given_name').defer,
        passportSurName: $wire.entangle('passport.sur_name').defer,
        passportCountry: $wire.entangle('passport.country').defer,
        passportRegion: $wire.entangle('passport.region').defer,
        passportDOB: $wire.entangle('passport.date_of_birth').defer,
        passportIssue: $wire.entangle('passport.issue_date').defer,
        passportExpiry: $wire.entangle('passport.expiry_date').defer,
        passportFile: $wire.entangle('passport.file'),
        passportCurrent: $wire.entangle('passport.active'),

        canPassportUpdate: $wire.checkPermission('user-passport-update'),
        chats: $wire.entangle('chats'),
        comments: $wire.entangle('comments').defer,
        validationErrors: $wire.entangle('validationErrors'),

        documentSelectedFile: '',
        bindPassportNumber: {
            ['x-model']: 'passportPassportNumber',
            //  ':value'() {
            //     return (this.passportSelected.passport_number !== undefined) ? this.passportPassportNumber = this.passportSelected.passport_number : this.passportPassportNumber
            // },
            ['id']: 'passport_number',
            ['name']: 'passport_number',
            ['type']: 'text',
            ['placeholder']: 'Enter your valid passport number',

        },

        bindPassportGivenName: {
            ['x-model']: 'passportGivenName',
            // ':value'() {
            //     return (this.passportSelected.given_name !== undefined) ? this.passportGivenName = this.passportSelected.given_name : this.passportGivenName
            // },
            ['id']: 'given_name',
            ['name']: 'given_name',
            ['type']: 'text',
            ['placeholder']: 'Enter your given name',

        },

        bindPassportSurName: {
            ['x-model']: 'passportSurName',
            // ':x-model'() {
            //     return (this.passportSelected.sur_name !== undefined) ? this.passportSurName = this.passportSelected.sur_name : this.passportSurName
            // },
            ['id']: 'sur_name',
            ['name']: 'sur_name',
            ['type']: 'text',
            ['placeholder']: 'Enter your sur name',
        },

        bindPassportCountry: {
            ['x-model']: 'passportCountry',
            ['id']: 'passport_country',
            ['name']: 'passport_country',
            'x-on:change'() {
                this.countryID = this.passportCountry;
                this.regionID = null;
                this.passportRegion = null;
            },
        },

        bindPassportRegion: {
            ['x-model']: 'passportRegion',
            ['id']: 'passport_region',
            ['name']: 'passport_region',
        },


        bindPassportCurrent: {
            ['x-model']: 'passportCurrent',
            ['id']: 'passport_current',
            ['name']: 'passport_current',
        },

        bindPassportDateOfBirth: {
            ['x-model']: 'passportDOB',
            ['type']: 'date',
            ['name']: 'date_of_birth',
            ['placeholder']: 'Enter Date of Birth',
            // ':value'() {
            //     return ((this.passportSelected.date_of_birth !== undefined) ? this.passportSelected.date_of_birth : '');
            // },
            ['readonly']: true,
            ':init'() {
                fpDob = flatpickr("#dob", this.dobConfig);
                this.resetInput = true
                return null;
            },
        },

        bindPassportIssueDate: {
            ['x-model']: 'passportIssue',
            ['type']: 'date',
            ['name']: 'issue_date',
            ['placeholder']: 'Enter passport issue date',
            ['readonly']: true,
            // ':value'() {
            //     return ((this.passportSelected.issue_date !== undefined) ? this.passportSelected.issue_date : '');
            // },
            ':init'() {
                fpIssue = flatpickr("#issue", this.issueConfig);
                this.resetInput = true
                return null;
            },
        },

        bindPassportExpiryDate: {
            ['x-model']: 'passportExpiry',
            ['type']: 'date',
            ['name']: 'expiry_date',
            ['placeholder']: 'Enter passport expiry date',
            // ['readonly']:true,
            ':init'() {
                fpExpiry = flatpickr("#expiry", this.expiryConfig);
                this.resetInput = true
                return null;
            }
        },
        // bindPassportFile: {
        //     ['x-model']: 'passportFile',
        //     ['name']: 'passport_file',
        // },


        dobConfig: {
            // altInput: true,
            altFormat: 'l, F j, Y',
            dateFormat: 'Y-m-d',
            onReady: function (selectedDates, dateStr, instance) {
                if (selectedDates.length > 0) {
                    instance.set({
                        // altInput: true,
                        altFormat: 'l, F j, Y',
                        defaultDate: flatpickr.parseDate('1978-08-20', "Y-m-d"),
                        dateFormat: 'Y-m-d',
                        minDate: '',
                        maxDate: 'today',
                        firstDayOfWeek: 1,
                        allowInput: false,
                        clickOpens: true,
                        enable: [function (date) {
                            return true
                        }],
                    });
                } else {
                    instance.set({
                        enable: [function (date) {
                            return true
                        }],
                        clickOpens: true,
                        maxDate: 'today',
                    });
                }
            },

            onChange: function (selectedDates, dateStr, instance) {

                fpIssue.clear();
                fpExpiry.clear();
                fpIssue.set({
                    enable: [function (date) {
                        return true
                    }],
                    clickOpens: true,
                    minDate: dateStr,
                    maxDate: 'today',

                })
                fpExpiry.set({
                    enable: [function (date) {
                        return false
                    }],
                    clickOpens: false,
                    minDate: '',
                    maxDate: '',
                })

            },
        },

        issueConfig: {
            // altInput: true,
            altFormat: 'F j, Y',
            dateFormat: 'Y-m-d',
            onReady: function (selectedDates, dateStr, instance) {

                if (fpDob.selectedDates.length > 0) {
                    instance.set({
                        // altInput: true,
                        altFormat: 'F j, Y',
                        defaultDate: '',
                        dateFormat: 'Y-m-d',
                        minDate: fpDob.selectedDates[0],
                        maxDate: 'today',
                        firstDayOfWeek: 1,
                        allowInput: false,
                        clickOpens: true,
                        enable: [function (date) {
                            return true
                        }],
                    });
                } else {
                    instance.set({
                        enable: [function (date) {
                            return false
                        }],
                        clickOpens: false,
                    });
                }
            },
            onChange: function (selectedDates, dateStr, instance) {
                fpExpiry.clear();
                fpExpiry.set({
                    enable: [function (date) {
                        return true
                    }],
                    clickOpens: true,
                    minDate: dateStr,
                    maxDate: '',

                })
            },
        },

        expiryConfig: {
            // altInput: true,
            altFormat: 'F j, Y',
            dateFormat: 'Y-m-d',
            onReady: function (selectedDates, dateStr, instance) {
                if (fpIssue.selectedDates.length > 0) {
                    instance.set({
                        // altInput: true,
                        altFormat: 'F j, Y',
                        defaultDate: '',
                        dateFormat: 'Y-m-d',
                        minDate: fpIssue.selectedDates[0],
                        maxDate: '',
                        firstDayOfWeek: 1,
                        allowInput: false,
                        clickOpens: true,
                        enable: [function (date) {
                            return true
                        }],
                    });
                } else {
                    instance.set({
                        enable: [function (date) {
                            return false
                        }],
                        clickOpens: false,
                    });
                }
            }
        },

        filterRegion(countryID) {
            this.regions = this.allRegions.filter(e => e.country_id === countryID);
        },



        commentsData() {
            return {
                'label': 'Comments',
                'livewireName': 'comments',
            }
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

        init() {
            // let passportDropzone = new Dropzone("input#passport-dropzone-file",{ url: "/file/post"});
            Alpine.effect(() => {
                this.fileValidationError = this.validationErrors['passport.file'];
                if (this.passportSelected.id !== undefined) {
                    this.passportPassportNumber = this.passportSelected.passport_number;
                        this.passportGivenName = this.passportSelected.given_name;
                        this.passportSurName = this.passportSelected.sur_name;
                        this.passportID = this.passportSelected.id;
                        this.countryID = this.passportSelected.countries_id;
                        this.regionID = this.passportSelected.regions_id;
                        this.passportCountry = this.passportSelected.countries_id;
                        this.passportRegion = this.passportSelected.regions_id;
                        this.passportDOB = this.passportSelected.date_of_birth;
                        this.passportIssue = this.passportSelected.issue_date;
                        this.passportExpiry = this.passportSelected.expiry_date;
                        // this.passportFile = this.passportSelected.file;
                        this.valueDob = this.passportSelected.date_of_birth
                        // console.log('countryID: ' + this.countryID);
                }

                // console.log(this.documentSelectedFile);

                if (this.passportSelected.countries_id !== undefined) {
                    this.countryID = this.passportSelected.countries_id;
                    // this.filteredRegions=$wire.regionData(this.countryID);
                    // this.allRegions.forEach(function(region){
                    //     console.log(region);
                    // })
                    // this.filteredRegions = this.allRegions.filter(function (obj) {
                    //     return obj.countryID ===data;
                    // });

                    // console.log(this.filteredRegions);
                }
                if (this.country !== '') {
                    this.recordCount = Object.keys(this.regionData).length;
                    if (this.recordCount) this.isRecord = true;
                } else {
                    this.isRecord = false;
                }

                // if (this.isFileExists === false || this.file === '') this.file = 'not-found.jpg';

                this.arrActive = [];
                this.arrActive.push(this.active);
                this.errorCount = Object.keys(this.validationErrors).length;
                // if (this.errorCount > 0) console.log(this.validationErrors);
            });
        },



    }))


});

export default class Passport {
}

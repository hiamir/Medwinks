import moment from "moment/moment";

document.addEventListener('alpine:init', function () {

    Alpine.data('Requirement', ($wire, data) => ({
        documentSelected:{},
        documents:{},
        documentID:data.documentID,
        activeStart:false,
        requirementData: $wire.requirement,
        requirements: data.requirements,
        isRecord: false,
        recordCount: 0,
        documentShow:false,
        isFileExists: $wire.entangle('document.isFileExists'),
        path: $wire.entangle('path'),
        tempName: $wire.entangle('tempName'),
        tempUrl: $wire.entangle('tempUrl'),
        requirement: $wire.entangle('document.service_requirement_id').defer,
        notes: $wire.entangle('document.notes').defer,
        documentName: $wire.entangle('document.name').defer,
        file: $wire.entangle('document.file').defer,
        validationErrors: $wire.entangle('validationErrors'),
        requirementTabID:$wire.entangle('requirementTabID'),
        chats:$wire.entangle('chats'),

        bindName: {
            ['x-model']: 'documentName',
            ['name']: 'Name',
            ['placeholder']: 'Enter document name',
            ':value'(){
                return ((this.documentSelected.name !==undefined) ? this.documentSelected.name : '' );
            },
            ':class'() {
                return this.classes.input;
            },
        },

        bindNotes:{
            ['x-model']: 'notes',
            ['name']: 'Notes',
            ['rows']:4,
            ['placeholder']: 'Enter notes',
            ':value'(){
                return ((this.documentSelected.notes !==undefined) ? this.documentSelected.notes : '' );
            },
            ':class'() {
                return this.classes.textarea;
            },
        },

        bindRequirement: {
            ['x-model']: 'requirement',
            ['name']: 'Service Requirement',
            ':value'(){
                console.log(this.documentSelected);
                return ((this.documentSelected.service_requirement_id !==undefined) ? this.documentSelected.service_requirement_id : '' );
            },
            ':class'() {
                return this.classes.select;
            },
        },

        bindFile: {
            ['name']: 'document.file',
            ':class'() {
                return this.classes.file;
            },
        },

        imageShow: {
            ':src'() {
                if(this.modalDetails.modalType !== 'add'){
                    let path = '';

                    (this.isFileExists) ? path = this.path + '?ver=' + Math.floor((Math.random() * 100) + 1) : path = 'storage/images/documents/not-found.jpg';
                    console.log(path);
                    return path;
                }else{
                    return '';
                }

            },
            ':class'() {
                return "w-16 h-16 border-2 border-gray-100"
            }
        },

        name() {
            return {
                'label': 'Name',
                'livewireName': 'document.name',
            }
        },

        notesDate(){
            return {
                'label': 'Notes',
                'livewireName': 'document.notes',
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

        serviceRequirement() {
            return {
                'name': 'documents',
                'label': 'Select a requirement',

                'livewireName': 'document.service_requirement_id',
                'placeholder': 'Choose a requirement',
                'options': this.requirementData,
            }
        },


        init() {
            Alpine.effect(() => {
                console.log(this.documentSelected);
               if(this.modalDetails.modalType === 'add') this.tempUrl=null;
            });
        },




    }))


});

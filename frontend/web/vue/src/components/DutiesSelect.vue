<template>
    <multiselect v-model="dutiesSelect"
                 :options="options"
                 tag-placeholder="Add this as new tag"
                 placeholder="Поиск или добавление тега"
                 label="name"
                 track-by="code"
                 :multiple="true"
                 :taggable="true"
                 :close-on-select="false"
                 :show-labels="false"
                 @tag="addTag"
                 @close="pushTags"
    ></multiselect>
</template>

<script>
    import Multiselect from 'vue-multiselect';

    export default {
        name: 'DutiesSelect',
        components: {Multiselect},
        data() {
            return {
                dutiesSelect: [],
                options: [
                    {
                        name: '',
                        id: '',
                        code: ''
                    }
                ]
            }
        },
        mounted() {
            this.$store.dispatch('getAllDuties', this.$route.params.id)
                .then(data => {
                    this.options = data;
                    let optAll = this.options;
                    for(let i = 0; i < optAll.length; i++) {
                        optAll[i]['code'] = optAll[i].id;
                    }
                }).catch(error => {
                this.$swal({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 4000,
                    type: 'error',
                    title: error.message
                })
            });
            if(this.$route.name === 'edit-resume/id') {
                this.$store.dispatch('getDuties', this.$route.params.id)
                    .then(data => {
                        this.dutiesSelect = data.skills;
                        let opt = this.dutiesSelect;
                        for(let i = 0; i < opt.length; i++) {
                            opt[i]['code'] = opt[i].id;
                        }
                    }).catch(error => {
                    this.$swal({
                        toast: true,
                        position: 'bottom-end',
                        showConfirmButton: false,
                        timer: 4000,
                        type: 'error',
                        title: error.message
                    })
                });
            }
        },
        methods: {
            addTag(newTag) {
                const tag = {
                    name: newTag,
                    code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
                };
                this.options.push(tag);
                this.dutiesSelect.push(tag);
            },
            pushTags(dutiesSelect) {
                this.$emit('input', dutiesSelect);
            },
        }
    }
</script>
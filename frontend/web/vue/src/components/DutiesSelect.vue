<template>
    <multiselect v-model="dutiesSelect"
                 :options="options"
                 tag-placeholder="Add this as new tag"
                 placeholder="Search or add a tag"
                 label="name"
                 track-by="code"
                 :multiple="true"
                 :taggable="true"
                 :close-on-select="false"
                 @tag="addTag"
                 @input="pushTags"
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
            this.getAllSkill().then(response => {
                this.options = response.data;
                let optAll = this.options;
                for(let i = 0; i < optAll.length; i++) {
                    optAll[i]['code'] = optAll[i].id;
                }
            }, response => {
                this.$swal({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 4000,
                    type: 'error',
                    title: response.data.message
                })
            });
            this.getSkills().then(response => {
                this.dutiesSelect = response.data.skills;
                let opt = this.dutiesSelect;
                for(let i = 0; i < opt.length; i++) {
                    opt[i]['code'] = opt[i].id;
                }
            }, response => {
                this.$swal({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 4000,
                    type: 'error',
                    title: response.data.message
                })
            });
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
            async getAllSkill() {
                return await this.$http.get(`${process.env.VUE_APP_API_URL}/request/skill?per-page=-1`);
            },
            async getSkills() {
                return await this.$http.get(`${process.env.VUE_APP_API_URL}/request/resume/` + this.$route.params.id + '?expand=skills');
            },
        }
    }
</script>
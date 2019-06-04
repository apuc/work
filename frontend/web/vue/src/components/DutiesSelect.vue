<template>
	<multiselect v-model="value"
							 :options="options"
							 tag-placeholder="Add this as new tag"
							 placeholder="Search or add a tag"
							 label="name"
							 track-by="id"
							 :multiple="true"
							 :taggable="true"
							 :close-on-select="false"
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
        value: [],
        options: [
          {
            name: '',
						id: ''
          }
        ]
			}
		},
    mounted() {
      this.getSkill().then(response => {
        this.options = response.data;
      });
		},
		methods: {
      addTag (newTag) {
        const tag = {
          name: newTag
        };
        this.options.push(tag);
        this.value.push(tag);
      },
      pushTags (dutiesSelect) {
        this.$emit('duties', dutiesSelect)
			},
      async getSkill() {
        return await this.$http.get(`${process.env.VUE_APP_API_URL}/request/skill?per-page=-1`);
      },
		}
	}
</script>
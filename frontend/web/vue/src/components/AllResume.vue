<template>

	<div>
		<div class="all-resume">

			<v-list two-line>

			<v-list-tile
				v-for="(item, index) in getAllResume"
				:key="index"
				style="margin-top: 20px;"
			>
				<v-list-tile-avatar>
					<img :src="'http://work.loc' + item.image_url" alt="">
				</v-list-tile-avatar>

				<v-list-tile-content>
					<v-list-tile-title class="mt-auto mb-auto"> {{ item.title }} </v-list-tile-title>
					<v-list-tile-sub-title class="mt-auto mb-auto"> {{ item.updated_at }} </v-list-tile-sub-title>
					<v-divider style="width: 100%;"></v-divider>
				</v-list-tile-content>
				<router-link :to="`${editLink}/${item.id}`">
					<v-btn outline small fab
								 class="edit-btn"
								 type="button"
					>
						<v-icon>edit</v-icon>

					</v-btn>
				</router-link>
				<v-btn outline small fab
							 class="edit-btn"
							 type="button"
							 @click="updateResume(item.id)"
				>
					<v-icon>arrow_upward</v-icon>
				</v-btn>
				<v-btn outline small fab
							 class="edit-btn"
							 type="button"
							 @click="removeResume(index, item.id)"
				>
					<v-icon>delete</v-icon>
				</v-btn>
			</v-list-tile>
			</v-list>

		</div>

		<div class="text-xs-center">
			<v-pagination
				v-model="paginationCurrentPage"
				:length="paginationPageCount"
				@input="changePage"
			></v-pagination>
		</div>

	</div>

</template>

<script>

  export default {
    name: "AllResume",
		data() {
      return {
        editLink: '/personal-area/edit-resume',
        getAllResume: [],
				paginationPageCount: 1,
				paginationCurrentPage: 1,
			}
		},
		created() {
      document.title = this.$route.meta.title;
        this.$http.get(`${process.env.VUE_APP_API_URL}/request/resume`)
          .then(response => {
              console.log(response);

            if (response.data.image_url) {
              this.imageUrl = 'http://work.loc' + response.data.image_url;
            }

						this.getAllResume = response.data;
						this.getAllResume.forEach((element) => {
						let timestamp = element.updated_at;
						let date = new Date();
						date.setTime(timestamp * 1000);
						element.updated_at = date.getDate() + '.' + date.getMonth() + '.' + date.getFullYear() + ' ' + date.getHours() + ':' + date.getMinutes();
						});
						this.paginationPageCount = response.headers.map['x-pagination-page-count'][0];

            console.log(this.getAllResume);
            console.log('Форма успешно отправлена');
            }, response => {
              console.log(response);
              console.log('Форма не отправлена');
            }
          );
			console.log(this.$http.headers);

		},
		methods: {
      // updateResume(resumeId) {
			//
			// },
      removeResume(index, resumeId) {
        this.getAllResume.splice(index, 1);
        this.$http.delete(`${process.env.VUE_APP_API_URL}/request/resume/` + resumeId)
          .then(response => {
              console.log(response);
              console.log('Форма успешно удалена');
            }, response => {
              console.log(response);
              console.log('Форма не удалена');
            }
          );
			},
      async changePage(paginationCurrentPage) {
        await this.$http.get(`${process.env.VUE_APP_API_URL}/request/resume?page=` + paginationCurrentPage)
          .then(response => {
              console.log(response);
              this.getAllResume = response.data;
              console.log(this.paginationPageCount);
              console.log(this.paginationCurrentPage);
              console.log('Форма успешно отправлена');
            }, response => {
              console.log(response);
              console.log('Форма не отправлена');
            }
          );
        console.log(this.paginationCurrentPage);
			}
		}
  }
</script>

<style scoped>
	.all-resume .theme--light.v-list {
		background-color: transparent;
	}
	/*.all-resume__item {*/
		/*display: flex;*/
		/*flex-direction: column;*/
		/*width: 300px;*/
		/*margin-top: 40px;*/
		/*margin-right: 50px;*/
	/*}*/
	/*.all-resume__item:nth-child(3n+3) {*/
		/*margin-right: 0;*/
	/*}*/
	a {
		text-decoration: none;
	}
</style>
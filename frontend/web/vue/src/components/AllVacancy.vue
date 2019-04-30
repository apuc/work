<template>

	<div>
		<div class="all-resume">

			<v-list two-line>

				<v-list-tile
					v-for="(item, index) in getAllVacancy"
					:key="index"
					style="margin-top: 20px;"
				>
					<v-list-tile-avatar>
						<img src="https://cdn.vuetifyjs.com/images/lists/1.jpg" alt="">
					</v-list-tile-avatar>

					<v-list-tile-content>
						<v-list-tile-title class="mt-auto mb-auto"> {{ item.post }} </v-list-tile-title>
						<v-list-tile-sub-title class="mt-auto mb-auto"> {{ item.update_time }} </v-list-tile-sub-title>
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
								 v-bind:disabled="item.can_update == false"
								 class="edit-btn"
								 type="button"
								 @click="updateVacancy(index, item.id)"
					>
						<v-icon>arrow_upward </v-icon>
					</v-btn>
					<v-btn outline small fab
								 class="edit-btn"
								 type="button"
								 @click="removeVacancy(index, item.id)"
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
        editLink: '/personal-area/edit-vacancy',
        getAllVacancy: [],
        paginationPageCount: 1,
        paginationCurrentPage: 1,
      }
    },
    created() {
      document.title = this.$route.meta.title;
      this.$http.get(`${process.env.VUE_APP_API_URL}/request/vacancy/my-index?expand=can_update&sort=-update_time`)
        .then(response => {
            console.log(response);
            this.getAllVacancy = response.data;
            this.getAllVacancy.forEach((element) => {
              let timestamp = element.update_time;
              let date = new Date();
              date.setTime(timestamp * 1000);
              element.update_time = date.getDate() + '.' + date.getMonth() + '.' + date.getFullYear() + ' ' + date.getHours() + ':' + date.getMinutes();
            });
            this.paginationPageCount = response.headers.map['x-pagination-page-count'][0];

            console.log(this.getAllVacancy);
            console.log('Форма успешно отправлена');
          }, response => {
            console.log(response);
            console.log('Форма не отправлена');
          }
        );
      console.log(this.$http.headers);

    },
    methods: {
      updateVacancy(index, vacancyId) {
        this.$http.post(`${process.env.VUE_APP_API_URL}/request/vacancy/update-time`, {id: vacancyId})
          .then(response => {
              this.getAllVacancy.splice(index, 1);
              let newData = response.data;
              let date = new Date();
              date.setTime(newData.update_time * 1000);
              newData.update_time = date.getDate() + '.' + date.getMonth() + '.' + date.getFullYear() + ' ' + date.getHours() + ':' + date.getMinutes();
              this.getAllVacancy.unshift(newData);
              console.log(response);
              console.log('Форма успешно удалена');
            }, response => {
              console.log(response);
              console.log('Форма не удалена');
            }
          );
      },
      removeVacancy(index, vacancyId) {
        this.getAllVacancy.splice(index, 1);
        this.$http.delete(`${process.env.VUE_APP_API_URL}/request/vacancy/` + vacancyId)
          .then(response => {
              console.log(response);
              console.log('Форма успешно удалена');
            }, response => {
              console.log(response);
              console.log('Форма не удалена');
            }
          );
      },
      changePage(paginationCurrentPage) {
        console.log(paginationCurrentPage);
        this.$http.get(`${process.env.VUE_APP_API_URL}/request/vacancy/my-index?page=` + paginationCurrentPage)
          .then(response => {
              console.log(response);
              this.getAllVacancy = response.data;
              console.log(this.paginationPageCount);
              console.log(this.paginationCurrentPage);
              console.log('Форма успешно отправлена');
            }, response => {
              console.log(response);
              console.log('Форма не отправлена');
            }
          );
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
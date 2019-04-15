const resume = {
  data() {
    return {
      hasImage: false,
      image: null,
      formData: {
        careerObjective: '',
        salaryFrom: '',
        salaryBefore: '',
        aboutMe: '',
        workBlock: [
          {
            name: '',
            post: '',
            department: '',
            month_from: '',
            year_from: '',
            month_to: '',
            year_to: '',
          }
        ],
        educationBlock: [
          {
            name: '',
            year_from: '',
            year_to: '',
            academic_degree: '',
            faculty: '',
            specialisation: '',
          }
        ],
        addSocial: {
          vkontakte: '',
          facebook: '',
          instagram: '',
          skype: '',
        },
      },
    };
  }
};

export default resume;
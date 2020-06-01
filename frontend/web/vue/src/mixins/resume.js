const resume = {
  data() {
    return {
      dataResume: [],
      hasImage: false,
      image: null,
      formData: {
        // birth_date: '',
        // phone: '',
        resumeCity: '',
        image_url: '',
        careerObjective: '',
        categoriesResume: [],
        salaryFrom: '',
        salaryBefore: '',
        workBlock: [
          {
            name: '',
            post: '',
            department: '',
            month_from: '',
            year_from: '',
            month_to: '',
            year_to: '',
            responsibility: ''
          }
        ],
        educationBlock: [
          {
            name: '',
            year_from: '',
            year_to: '',
            academic_degree: '',
            faculty: '',
            specialisation: ''
          }
        ],
        addSocial: {
          vkontakte: '',
          facebook: '',
          instagram: '',
          skype: ''
        },
        dutiesSelect: [],
        aboutMe: '',
        hideResume: false
      },
      valid: false
    };
  }
};

export default resume;
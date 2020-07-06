const resume = {
  data() {
    return {
      dataResume: [],
      hasImage: false,
      show: false,
      image: null,
      menu: false,
      formData: {
        birth_date: '',
        phone: '',
        resumeCity: null,
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
        hideResume: false,
        phoneValid: false
      },
      defaultCountry: {
        iso2: '',
        dialCode: ''
      },
      allCountries: [
        {
          areaCodes: null,
          dialCode: "380",
          iso2: "UA",
          name: "Ukraine (Україна)",
          priority: 0
        },
        {
          areaCodes: null,
          dialCode: "7",
          iso2: "RU",
          name: "Russia (Россия)",
          priority: 0
        }
      ],
      phone: {
        text: '',
        valid: false,
      },
      valid: false
    };
  }
};

export default resume;
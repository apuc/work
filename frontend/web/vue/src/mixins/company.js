const company = {
  data() {
    return {
      dataCompany: [],
      hasImage: false,
      image: null,
      formData: {
        image_url: '',
        privatePerson: false,
        nameCompany: '',
        site: '',
        scopeOfTheCompany: '',
        addSocial: {
          vkontakte: '',
          facebook: '',
          instagram: '',
          skype: '',
        },
        aboutCompany: '',
        contactPerson: '',
        companyPhone: ''
      },
      valid: false
    };
  }
};

export default company;
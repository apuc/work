const company = {
  data() {
    return {
      hasImage: false,
      image: null,
      formData: {
        image_url: '',
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
    };
  }
};

export default company;
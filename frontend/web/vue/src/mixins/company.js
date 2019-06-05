const company = {
  data() {
    return {
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
    };
  }
};

export default company;
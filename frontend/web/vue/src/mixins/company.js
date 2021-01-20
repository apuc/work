const company = {
  data() {
    return {
      companiesCount: 0,
      dataCompany: [],
      hasImage: false,
      show: false,
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
        companyPhone: '',
        phoneValid: false
      },
      defaultCountry: {
        iso2: 'UA',
        dialCode: '380'
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

export default company;
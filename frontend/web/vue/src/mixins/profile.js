const profile = {
  data() {
    return {
      dataProfile: [] ,
      idEmployer: '',
      menu: false,
      formData: {
        first_name: '',
        second_name: '',
        birth_date: '',
        email: '',
        phone: '',
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
    };
  }
};

export default profile;

const vacancy = {
  data() {
    return {
      dataVacancy: [],
      companyFlag: '',
      formData: {
        phone: '',
        vacancyCity: '',
        category: {
          mainCategoriesVacancy: null,
          subcategories: [],
        },
        post: '',
        duties: '',
        typeOfEmployment: null,
        salaryFrom: '',
        salaryBefore: '',
        qualificationRequirements: '',
        description: '',
        experience: '',
        education: '',
        workingConditions: '',
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

export default vacancy;
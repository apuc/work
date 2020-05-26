const vacancy = {
  data() {
    return {
      dataVacancy: [],
      lengthCompany: 0,
      formData: {
        phone: '',
        vacancyCity: '',
        companyName: [],
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
        workingConditions: ''
      },
      valid: false,
      defaultCountry: {
        iso2: '',
        dialCode: ''
      },
      allCountries: [
        {
          areaCodes: null,
          dialCode: "38",
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
        valid: false,
      },
    };
  }
};

export default vacancy;
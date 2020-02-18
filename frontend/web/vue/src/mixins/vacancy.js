const vacancy = {
  data() {
    return {
      dataVacancy: [],
      lengthCompany: 0,
      formData: {
        vacancyCity: '',
        companyName: [],
        mainCategoriesVacancy: null,
        subcategories: [],
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
        vacancyVideo: '',
        officeAddress: '',
        houseNumber: '',
      },
      valid: false
    };
  }
};

export default vacancy;
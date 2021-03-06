const rest = {
  candidate: {
    add: 'api/candidate/addCandidate.php'
  },
  subject: {
    get: 'api/subject/getAllSubjects.php'
  },
  speciality: {
    get: 'api/speciality/getAllSpecialities.php',
    update: 'api/speciality/updateSpeciality.php',
    getRanking: 'api/speciality/getRanking.php?specialityId='
  },
  polling: 'api/rankingStatus.php?specialityId='
}
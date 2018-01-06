candidateGrades = [];
candidateWishes = [];

function validateGrade({ value, subject }) {
  let errors = [];
  if (value < 2)
    errors.push('Grade must be above 2');
  if (value > 6)
    errors.push('Grade must be below 6');

  return { status: errors.length, errors: errors };
}
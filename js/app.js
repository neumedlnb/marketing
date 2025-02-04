document.addEventListener('DOMContentLoaded', function() {

  // 개인정보 취급방침 팝업 처리
  var privacyPolicyBtn = document.getElementById('privacy-policy-btn');
  var privacyPopup = document.getElementById('privacy-popup');
  var closePopupBtn = document.getElementById('close-popup');

  privacyPolicyBtn.addEventListener('click', function() {
    privacyPopup.style.display = 'block';
  });

  closePopupBtn.addEventListener('click', function() {
    privacyPopup.style.display = 'none';
  });

  var form = document.getElementById('contact-form');

  form.addEventListener('submit', function(e) {
    e.preventDefault();

    var formData = new URLSearchParams();

    // 1. 성함, 2. 이메일, 3. 전화번호, 4. 희망원고료, 5.카테고리, 6.팔로워, 7.블로그 또는 매체 URL
    formData.append('userName', form.userName.value);
    formData.append('userEmail', form.userEmail.value);
    formData.append('userPhone', form.userPhone.value);
    formData.append('desiredFee', form.desiredFee.value);
    formData.append('category', form.category.value);
    formData.append('visitor', form.visitor.value);
    formData.append('blog', form.blog.value);

    // **8. 키클래오 제품 급여 경험** (이 항목은 바로 희망원고료 다음에 추가)
    var productExperience = form.querySelectorAll('input[name="product_experience[]"]:checked');
    productExperience.forEach(function(item) {
      formData.append('product_experience[]', item.value);
    });

    // 9. 제공 가능한 콘텐츠 유형
    var contentTypes = form.querySelectorAll('input[name="content_type[]"]:checked');
    contentTypes.forEach(function(item) {
      formData.append('content_type[]', item.value);
    });

    // 7. 제작해주신 영상, 이미지 콘텐츠 2차 가공 사용 동의 여부
    var consentContents = form.querySelectorAll('input[name="consentContent[]"]:checked');
    consentContents.forEach(function(item) {
      formData.append('consentContent[]', item.value);
    });

    // 8. 네이버 블로그 콘텐츠 광고 등록 가능 여부
    var adStatus = form.querySelectorAll('input[name="ad_status[]"]:checked');
    adStatus.forEach(function(item) {
      formData.append('ad_status[]', item.value);
    });

    // 9. 아이 연령대
    var childAges = form.querySelectorAll('input[name="childAge[]"]:checked');
    childAges.forEach(function(item) {
      formData.append('childAge[]', item.value);
    });

    // 10. 아이 성별
    var childGenders = form.querySelectorAll('input[name="childGender[]"]:checked');
    childGenders.forEach(function(item) {
      formData.append('childGender[]', item.value);
    });

    // 11. 아이의 키와 관련해 도움을 받으려 시도한 경험
    var growthAttempts = form.querySelectorAll('input[name="growthAttempt[]"]:checked');
    growthAttempts.forEach(function(item) {
      formData.append('growthAttempt[]', item.value);
    });

    // 12. 자녀의 키 성장 제품 선택 시 중요한 요소
    var growthPriorities = form.querySelectorAll('input[name="growthPriority[]"]:checked');
    growthPriorities.forEach(function(item) {
      formData.append('growthPriority[]', item.value);
    });

    // 13. 촬영 시 제공 가능한 콘텐츠의 형태
    var contentTypesProvided = form.querySelectorAll('input[name="contentType[]"]:checked');
    contentTypesProvided.forEach(function(item) {
      formData.append('contentType[]', item.value);
    });

    // 14. 개인정보동의체크
    if (!form.privacy.checked) {
      alert("개인정보 취급방침에 동의해 주세요.");
      return;
    }
    formData.append('privacy', "동의");

    var scriptURL = 'https://script.google.com/macros/s/AKfycbzx8zh_bcod9KylTsYdmUmiA0EB3M7txVk9BYKZjjha-MQCf-2b2pjvGOQ831S1e9Jc/exec';

    fetch(scriptURL, {
      method: 'POST',
      mode: 'cors',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: formData.toString()
    })
    .then(response => response.json())
    .then(data => {
      console.log('Success:', data);
      alert('신청이 완료되었습니다.');
      form.reset();
    })
    .catch(error => {
      console.error('Error:', error);
      alert('신청이 완료되었습니다.');
    });
  });
});

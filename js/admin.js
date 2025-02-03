document.addEventListener('DOMContentLoaded', function() {
    const refreshBtn = document.getElementById('refreshBtn');
    const downloadBtn = document.getElementById('downloadBtn');
    const dataTableBody = document.querySelector('#dataTable tbody');
  
    // 데이터 조회 함수
    function fetchData() {
      fetch('get_data.php')
        .then(response => response.json())
        .then(data => {
          dataTableBody.innerHTML = '';
          data.forEach(row => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
              <td>${row.id}</td>
              <td>${row.timestamp}</td>
              <td>${row.userName}</td>
              <td>${row.userEmail}</td>
              <td>${row.userPhone}</td>
              <td>${row.desiredFee}</td>
              <td>${row.content_type}</td>
              <td>${row.ad_status}</td>
              <td>${row.childAge}</td>
              <td>${row.childGender}</td>
              <td>${row.growthAttempt}</td>
              <td>${row.growthPriority}</td>
              <td>${row.consentContent}</td>
              <td>${row.contentType}</td>
              <td>${row.privacy}</td>
            `;
            dataTableBody.appendChild(tr);
          });
        })
        .catch(error => console.error('데이터 조회 오류:', error));
    }
  
    refreshBtn.addEventListener('click', fetchData);
  
    downloadBtn.addEventListener('click', function() {
      window.location.href = 'download_data.php';
    });
  
    // 페이지 로드 시 데이터 조회
    fetchData();
  });
  
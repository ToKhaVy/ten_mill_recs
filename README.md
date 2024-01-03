3 ae làm bài tập này nha, ưu tiên hơn mấy bài tập hiện tại.

- Tạo 1 bảng USER có các cột
  ID (int), FirstName(varchar255), LastName(varchar255), Address(text), Birthday(varchar255)

Yêu cầu:

1. Chèn 10 triệu record vào bảng trên với điều kiện như dưới. Tìm cách tối ưu tốc độ để chèn nhanh nhất có thể.
   ※ Viết ra 1 phương án thơ ngây nhất, tìm hiểu có vấn đề gì ko, sau đó cải thiện dần, đưa ra thời gian chạy của từng phương án, sau mỗi lần cải thiện thì tăng lên được bao nhiêu

- ID không trùng
- FirstName, LastName, Address tìm thư viện Faker nào đó để sinh ngẫu nhiên (https://fakerphp.github.io/)
- Birthday kiểu Apr-03-2015 (Kiểu string)

2. Export toàn bộ dữ liệu trên ra định dạng CSV, nhanh nhất có thể
   ※ Viết ra 1 phương án thơ ngây nhất, tìm hiểu có vấn đề gì ko, sau đó cải thiện dần, đưa ra thời gian chạy của từng phương án, sau mỗi lần cải thiện thì tăng lên được bao nhiêu

3. Export toàn bộ dữ liệu trên theo định dạng CSV theo điều kiện Address, Birthday và sắp xếp tăng giảm theo Birthday
   ※ Viết ra 1 phương án thơ ngây nhất, tìm hiểu có vấn đề gì ko, sau đó cải thiện dần, đưa ra thời gian chạy của từng phương án, sau mỗi lần cải thiện thì tăng lên được bao nhiêu

4. Với mỗi phương án trong yêu cầu 1, 2, 3 thì làm file báo cáo so sánh về thời gian chạy

※ Source code làm xong với mỗi phương án thì commit lên GIT để so sánh nha
※Deadline: Hết thứ 5 tuần sau(4/1/2024)

1. Import records.
   Case 1: Single insert statement. (while loop).
   Tạo file CSV:

- 100.000 records: 26 sec.
- 1.000.000 records: 576,6581 sec (~ 10 min)
- 10.000.000 records: 3.179,9215 sec (~53 min)
  Insert vào DB:
- 10.000 records: 6,0702 sec
- 100.000 records: 58,6816 sec
- 1.000.000 records: 1.368,6942 sec (~23 min)
- 10.000.000 records: 6.097,6544 sec (~101 min)
  Case 2: Batch insert.
  Batch size: 1000
- 100.000 records: 5,4408 sec
- 1.000.000 records: 58,2227 sec
- 10.000.000 records: 730,7397 sec (~12,2 min)
  Batch size: 5000
- 100.000 records: 6,5721 sec
- 1.000.000 records: 71,9272 sec
- 10.000.000 records: 813,1007 sec (~14 min)
  Batch size: 10000
- 100.000 records: 7,1157 sec
- 1.000.000 records: 76,7276 sec
- 10.000.000 records: 782,7272 sec (~13 min)
  Case 3: Batch insert + Transaction management
  Batch size: 1000
- 100.000 records: 5,3410 sec
- 1.000.000 records: 50,6756 sec
- 10.000.000 records: 636,0383 sec (~10,5 min)
  Batch size: 5000
- 100.000 records: 5,2412 sec
- 1.000.000 records: 51,1666 sec
- 10.000.000 records: 591,5396 sec (~9,8 min)
  Batch size: 10000
- 100.000 records: 7,1157 sec
- 1.000.000 records: 51,1941 sec
- 10.000.000 records: 518,4232 sec (~8,5 min)

1. Network Latency
   • Each `INSERT` statement involves a network round trip between PHP script and the MySQL server.
2. Transaction Size
3. Indexes an Constrants
4. DB Engine
5. Server Configuration
6. PHP Execution Time
7. Hardware Resources

I. EFFICIENCY
II. PERFOMANCE

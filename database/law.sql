/*
 Navicat Premium Data Transfer

 Source Server         : DB - google console 35.240.164.178
 Source Server Type    : MySQL
 Source Server Version : 80035
 Source Host           : 35.240.164.178:3306
 Source Schema         : law

 Target Server Type    : MySQL
 Target Server Version : 80035
 File Encoding         : 65001

 Date: 17/01/2024 18:02:08
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for law_info
-- ----------------------------
DROP TABLE IF EXISTS `law_info`;
CREATE TABLE `law_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `start_work` datetime DEFAULT NULL,
  `law_type` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `intro_text` varchar(1000) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `image_url` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `creator_id` int DEFAULT NULL,
  `updator_id` int DEFAULT NULL,
  `status` tinyint DEFAULT '0',
  `rating` int DEFAULT NULL,
  `price` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- ----------------------------
-- Records of law_info
-- ----------------------------
BEGIN;
INSERT INTO `law_info` VALUES (1, 6, 'Nguyễn Anh Đức', '0915220884', 'Quận Cầu Giấy, Thành phố Hà Nội', NULL, '1,2,3,4,5', 'Luật sư Nguyễn Anh Đức là Luật sư thuộc Đoàn luật sư thành phố Hà Nội, chuyên sâu về lĩnh vực tranh tụng trong các vụ án hình sự, dân sự, hành chính, đất đai, kinh doanh thương mại … Với nhiều năm kinh nghiệm, Luật sư đã tham gia bào chữa, bảo vệ quyền lợi cho nhiều khách hàng trong nhiều vụ án khó, án phức tạp, án oan sai. \n\nVới phương châm \"Quyền lợi hợp pháp của khách hàng là trên hết\", Luật sư Nguyễn Anh Đức luôn tư vấn và hỗ trợ giải pháp pháp lý tốt nhất cho vụ việc của khách hàng. Đồng thời, Luật sư cũng sẵn sàng hỗ trợ, tư vấn pháp lý miễn phí cho người nghèo và các đối tượng chính sách.', '<div style=\"text-align: justify;\"><p style=\"overflow-wrap: break-word; word-break: break-word; margin: 0cm 0cm 9pt; color: rgb(51, 51, 51); font-family: Roboto, Avenir, &quot;Century Gothic&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 16px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span style=\"font-family: Roboto;\">Luật sư Nguyễn Tâm thuộc Đoàn Luật sư Tp. HCM, hiện Luật sư đang là Giám đốc công ty luật Nguyễn Tâm&nbsp; &amp; Cộng sự.</span><o:p></o:p></p><p style=\"overflow-wrap: break-word; word-break: break-word; margin: 0cm 0cm 9pt; color: rgb(51, 51, 51); font-family: Roboto, Avenir, &quot;Century Gothic&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 16px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span style=\"font-family: Roboto;\">Ngoài ra luật sư Nguyễn Tâm không ngừng phấn đấu, học hỏi thêm nhiều kinh nghiệm để luôn mang tới cho khách hàng lợi ích cao nhất, đúng như Slogan của công ty “ AN TOÀN PHÁP LÝ – VỮNG CHẮC THÀNH CÔNG”. Điều hành Hãng Luật Nguyễn Tâm &amp; Partners là Luật sư Nguyễn Tâm với kinh nghiệm gần 10 năm hành nghề luật, hiện nay ông đang công tác tại Đoàn Luật sư Tp. Hồ Chí Minh, ông đã nhận được nhiều bằng khen của Đoàn luật sư, Đoàn khối Dân – Chính – Đảng Tp. Hồ Chí Minh</span><o:p></o:p></p><p style=\"overflow-wrap: break-word; word-break: break-word; margin: 0cm 0cm 9pt; color: rgb(51, 51, 51); font-family: Roboto, Avenir, &quot;Century Gothic&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 16px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span style=\"font-family: Roboto;\">Là một luật sư uy tin, có chuyên môn với nhiều năm kinh nghiệm hành nghề chuyên sâu trong nhiều lĩnh vực: kinh doanh, thu hồi quản lý công nợ, sở hữu trí tuệ, tư vấn đầu tư trong nước và nước ngoài, dịch thuật công chứng, thực hiện các thủ tục pháp lý liên quan tới người nước ngoài,... hiện tại đang làm việc tại Hồ Chí Minh và các tỉnh thành khác.</span><o:p></o:p></p><p style=\"overflow-wrap: break-word; word-break: break-word; margin: 0cm 0cm 9pt; color: rgb(51, 51, 51); font-family: Roboto, Avenir, &quot;Century Gothic&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 16px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span style=\"font-family: Roboto;\">Luật sư Nguyễn Tâm đã tư vấn thành công cho nhiều khách hàng ở nhiều mảng dịch vụ đa dạng,... thông qua việc đặt câu hỏi, đặt lịch hẹn tư vấn luật sư qua mail, điện thoại, gặp mặt trực tuyến nhằm hạn chế rủi ro để khách hàng gặp phải.</span><o:p></o:p></p><p style=\"overflow-wrap: break-word; word-break: break-word; margin: 0cm 0cm 9pt; color: rgb(51, 51, 51); font-family: Roboto, Avenir, &quot;Century Gothic&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 16px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span style=\"font-family: Roboto;\">Với phương châm luôn hướng tới lợi ích cao nhất cho khách hàng, khách hàng sẽ được tư vấn các giải pháp tối ưu nhất để giải quyết vấn đề của mình. Ngoài ra Luật sư Tâm luôn sẵn sàng chia sẻ và hỗ trợ pháp lý miễn phí cho các đối tượng chính sách và gia đình khó khăn. Công ty Luật Nguyễn Tâm &amp; Cộng sự được iLAW vinh danh là một trong hai tổ chức hành nghề luật tiêu biểu trong năm 2017.</span><o:p></o:p></p><p style=\"overflow-wrap: break-word; word-break: break-word; margin: 0cm 0cm 9pt; color: rgb(51, 51, 51); font-family: Roboto, Avenir, &quot;Century Gothic&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 16px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span style=\"font-family: Roboto;\">Liên hệ Luật sư tại văn phòng:</span><o:p></o:p></p><p style=\"overflow-wrap: break-word; word-break: break-word; margin: 0cm 0cm 9pt; color: rgb(51, 51, 51); font-family: Roboto, Avenir, &quot;Century Gothic&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 16px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span style=\"font-family: Roboto;\">+ 474/10 Nguyễn Thái Sơn, p5, quận Gò Vấp, Tp HCM</span><o:p></o:p></p><p style=\"overflow-wrap: break-word; word-break: break-word; margin: 0cm 0cm 9pt; color: rgb(51, 51, 51); font-family: Roboto, Avenir, &quot;Century Gothic&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 16px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span style=\"font-family: Roboto;\">+&nbsp;37 đường Tân Thới Hiệp 09, phường Tân Thới Hiệp, quận 12 (đối diện tòa án quận 12) TP Hồ Chí Minh</span></p></div>', 'https://i-law.vn/Uploads/users/User_img_4315_04112020141738.jpg', NULL, NULL, NULL, NULL, 1, 4, 200000);
INSERT INTO `law_info` VALUES (2, 3, 'Võ Thanh Khương', '0905206381', 'Quận 1, Thành phố Hồ Chí Minh', NULL, '2,4,5', 'Luật sư VÕ THANH KHƯƠNG (Luật sư) là người sáng lập và hiện đang giữ chức vụ Giám đốc điều hành của Công ty Luật TNHH Logic & Cộng sự (LOGICLAW) tại thành phố Hồ Chí Minh. Luật sư là thành viên của Đoàn luật sư thành phố Hồ Chí Minh, Liên đoàn luật sư Việt Nam.', '<div class=\"is-truncated\" data-truncate-lines=\"3\" id=\"js-truncated-aboutme\" data-truncate-label=\"Less <span aria-hidden=&quot;true&quot; class=&quot;icon fas fa-angle-up&quot;></span>\" aria-expanded=\"false\" style=\"overflow-wrap: break-word;\">\n                                                                     <p class=\"MsoNormal\" style=\"margin: 6pt 0cm; font-size: medium; font-family: Calibri, sans-serif; text-align: justify;\"><span style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">Luật sư VÕ</span><span lang=\"VI\" style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">&nbsp;THANH KHƯƠNG&nbsp;</span><span lang=\"VI\" style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">(Luật sư)&nbsp;</span><span style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">là</span><span lang=\"VI\" style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">&nbsp;người sáng lập và&nbsp;</span><span style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">hiện đang giữ chức vụ Giám đốc điều&nbsp;</span><span lang=\"VI\" style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">hành&nbsp;</span><span style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">của Công ty Luật TNHH Logic</span><span lang=\"VI\" style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">&nbsp;&amp; Cộng sự (LOGICLAW)</span><span style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">&nbsp;tại&nbsp;</span><span lang=\"VI\" style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">t</span><span style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">hành phố Hồ Chí Minh</span><span lang=\"VI\" style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">. Luật sư là thành viên của Đoàn luật sư thành phố Hồ Chí Minh, Liên đoàn luật sư Việt Nam.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 6pt 0cm; font-size: medium; font-family: Calibri, sans-serif; text-align: justify;\"><span style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">Luật sư có hơn 13</span><span style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">&nbsp;năm kinh nghiệm trong các lĩnh vực Doanh&nbsp;nghiệp, M&amp;A, Đầu</span><span lang=\"VI\" style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">&nbsp;tư, Kinh doanh - Thương mại, Bất động sản, Đất đai,&nbsp;</span><span style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">Hôn nhân &amp; Gia đình, Di chúc - Thừa kế,&nbsp;Dân sự,</span><span lang=\"VI\" style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">&nbsp;Sở hữu trí tuệ,&nbsp;</span><span style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">Hình sự, Hành</span><span lang=\"VI\" style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">&nbsp;chính,&nbsp;</span><span style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">Lao động - Bảo hiểm xã hội,</span><span lang=\"VI\" style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">&nbsp;Thuế,&nbsp;</span><span style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">…</span><span lang=\"VI\" style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 6pt 0cm; font-size: medium; font-family: Calibri, sans-serif; text-align: justify;\"><span lang=\"VI\" style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">Đặt biệt, Luật sư chuyên nhận những vụ việc khó, phức tạp trong nhiều lĩnh vực; với kinh nghiệm thực tế cùng với khả năng lập luận, tư duy pháp lý một cách “LOGIC”, xác định được mấu chốt, trọng tâm của vấn đề vốn là điểm mạnh của mình, Luật sư đã mang lại nhiều vụ việc thành công cho khách hàng, thân chủ tại thành phố Hồ Chí Minh và các tỉnh thành khác trên cả nước.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 6pt 0cm; font-size: medium; font-family: Calibri, sans-serif; text-align: justify;\"><span lang=\"VI\" style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">Để phòng tránh hoặc giảm thiểu những rủi ro pháp lý trong hoạt động kinh doanh, hoặc để giải quyết những vấn đề pháp lý một cách tốt nhất mà bạn đang gặp phải, bạn có thể liên hệ với Luật sư VÕ THANH KHƯƠNG theo thông tin sau đây để được tư vấn, hướng dẫn, xử lý kịp thời:<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 6pt 0cm; font-size: medium; font-family: Calibri, sans-serif; text-align: justify;\"><span style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">Số điện thoại liên hệ:&nbsp;</span><span lang=\"VI\" style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\"><b>090 520 63 81</b><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 6pt 0cm; font-size: medium; font-family: Calibri, sans-serif; text-align: justify;\"><span style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">Email</span><span lang=\"VI\" style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">:&nbsp;</span><a href=\"mailto:luatsulogic@gmail.com\" style=\"color: rgb(149, 79, 114); text-decoration: underline;\"><span lang=\"VI\" style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif;\">luatsulogic@gmail.com</span></a><span lang=\"VI\" style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 6pt 0cm; font-size: medium; font-family: Calibri, sans-serif; text-align: justify;\"><span lang=\"VI\" style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\"><b>CÔNG TY LUẬT TNHH LOGIC &amp; CỘNG SỰ</b><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 6pt 0cm; font-size: medium; font-family: Calibri, sans-serif; text-align: justify;\"><span style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">Địa chỉ tr</span><span lang=\"VI\" style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">ụ sở</span><span style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">&nbsp;chính: Tầng</span><span lang=\"VI\" style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">&nbsp;1, Toà nhà Packsimex, số 52 Đông Du, phường Bến Nghé</span><span style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">, Quận 1, T</span><span lang=\"VI\" style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">P.</span><span lang=\"VI\" style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">&nbsp;</span><span style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">H</span><span lang=\"VI\" style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">ồ Chí Minh.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin: 6pt 0cm; font-size: medium; font-family: Calibri, sans-serif; text-align: justify;\"><span style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">Văn phòng giao dịch : Số 441/17 (số cũ&nbsp;</span><span lang=\"VI\" style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">441/15B) Điện Biên Phủ, phường 25, quận Bình Thạnh, TP. Hồ Chí Minh</span><span style=\"font-size: 14pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(51, 51, 51);\">.<o:p></o:p></span></p>                 \n                                                </div>', 'https://i-law.vn/Uploads/users/User_img_6971_23062021142200.jpg', NULL, NULL, NULL, NULL, 1, 5, 150000);
INSERT INTO `law_info` VALUES (3, 4, 'Nguyễn Văn Tiến', '0989878181', 'Quận Bình Tân, Thành phố Hồ Chí Minh', NULL, '1,3,5,4', 'Luật sư Nguyễn Văn Tiến có hơn 10 năm kinh nghiệm pháp lý với nhiều lĩnh vực khác nhau như: Kinh doanh thương mại,  Hình sự, Hành chính, Đất đai, hôn nhân gia đình. Hiện nay, là Luật sư điều hành Văn phòng luật sư Đại Quốc Việt và là cố vấn pháp lý cho một số doanh nghiệp lớn trong lĩnh vực xuất nhập khẩu. Với nhiều năm kinh nghiệm trong nghiên cứu và tham gia tranh tụng', '<div class=\"is-truncated\" data-truncate-lines=\"3\" id=\"js-truncated-aboutme\" data-truncate-label=\"Less <span aria-hidden=&quot;true&quot; class=&quot;icon fas fa-angle-up&quot;></span>\" aria-expanded=\"false\" style=\"overflow-wrap: break-word;\">\n                                                           <p class=\"MsoNormal\" style=\"text-align: justify; \">Luật sư Nguyễn Văn Tiến có hơn 10 năm kinh nghiệm pháp lý với\nnhiều lĩnh vực khác nhau như: Kinh doanh thương mại,&nbsp; Hình sự, Hành chính, Đất đai, hôn nhân gia\nđình. Hiện nay, là Luật sư điều hành Văn phòng luật sư Đại Quốc Việt và là cố vấn\npháp lý cho một số doanh nghiệp lớn trong lĩnh vực xuất nhập khẩu. Với nhiều\nnăm kinh nghiệm trong nghiên cứu và tham gia tranh tụng, </p><p class=\"MsoNormal\" style=\"text-align: justify; \"><span style=\"font-family: Roboto;\">Luật sư Tiến đã giúp bảo\nvệ quyền lợi của khách hàng một tốt nhất. Luật sư Tiến đã từng tham gia rất nhiều\nvụ án để bào chữa, bảo vệ cho khách hàng và đạt rất nhiều thành công trong các\nvụ án hình sự, dân sự, tranh chấp về Đất đai; lao động. Soạn thảo và đàm phán\ntrong hợp đồng, tranh chấp về kinh doanh – thương mại..</span><o:p></o:p></p>       \n                                                </div>', 'https://i-law.vn/Uploads/users/User_img_437_25052021110045.jpg', NULL, NULL, NULL, NULL, 1, 3, 150000);
INSERT INTO `law_info` VALUES (4, 5, 'Trịnh Thị Hạnh', '0937621936', 'Quận Tân Bình, Thành phố Hồ Chí Minh', NULL, '3,4,2', 'Luật sư Trịnh Thị Hạnh tốt nghiệp trường Đại học Luật Hà Nội, hiện là Giám đốc điều hành của Công ty luật Hạnh Minh - Đoàn Luật sư TP.HCM. Luật sư Trịnh Thị Hạnh đã có hơn 10 năm kinh nghiệm hoạt động pháp luật và đang cung cấp dịch vụ pháp lý.', '<div class=\"is-truncated\" data-truncate-lines=\"3\" id=\"js-truncated-aboutme\" data-truncate-label=\"Less <span aria-hidden=&quot;true&quot; class=&quot;icon fas fa-angle-up&quot;></span>\" aria-expanded=\"false\" style=\"overflow-wrap: break-word;\">\n                                                                                               <p style=\"text-align: justify; margin-bottom: 20px;\">&nbsp;&nbsp;&nbsp;&nbsp;Luật sư Trịnh Thị Hạnh tốt nghiệp trường Đại học Luật Hà Nội, hiện là Giám đốc điều hành của Công ty luật Hạnh Minh - Đoàn Luật sư TP.HCM. Luật sư Trịnh Thị Hạnh đã có hơn 10 năm kinh nghiệm hoạt động pháp luật và đang cung cấp dịch vụ pháp lý trong các lĩnh vực: </p><p style=\"text-align: justify; margin-bottom: 20px;\">-&nbsp;<span style=\"font-size: 1.6rem;\">Tham gia bào chữa các vụ án Hình sự;</span></p><p style=\"text-align: justify; margin-bottom: 20px;\"><span style=\"font-size: 1.6rem;\">- Tham gia tố tụng giải quyết tranh chấp Hôn nhân gia đình, Đất đai, Thừa kế, Lao động, Kinh doanh thương mại...;</span><br></p><p style=\"text-align: justify; margin-bottom: 20px;\"><span style=\"font-size: 1.6rem;\">- Tham gia các vụ khiếu nại, khởi kiện trong lĩnh vực Hành chính;</span><br></p><p style=\"text-align: justify; margin-bottom: 20px;\">- Đại diện ngoài tố tụng cho khách hàng tham gia thương lượng, giải quyết tranh chấp không qua khởi kiện...</p><p style=\"text-align: justify; margin-bottom: 20px;\">- Tư vấn pháp lý thường xuyên cho các Doanh nghiệp;</p><p style=\"text-align: justify; margin-bottom: 20px;\">- Tư vấn pháp luật, cung cấp dịch vụ LUẬT SƯ RIÊNG cho cá nhân, gia đình.</p><p style=\"text-align: justify; margin-bottom: 20px;\">Quá trình hoạt động hành nghề tích cực, liên tục hàng chục năm đã giúp Luật sư Trịnh Thị Hạnh tích lũy được vốn kiến thức và kinh nghiệm sâu rộng, tác phong làm việc chuyên nghiệp cùng với tư duy pháp lý nhạy bén đã nhận diện và&nbsp; giải quyết hiệu quả các vụ việc/vụ án trong tất cả các lĩnh vực Dân sự, Hình sự, Kinh doanh Thương&nbsp; mại, Hành chính...Với phương châm \"<i>việc của khách là việc của nhà mình</i>\",&nbsp;<span style=\"font-size: 1.6rem;\">Luật sư Trịnh Thị Hạnh luôn nỗ lực nhằm đảm bảo tốt nhất quyền lợi hợp pháp của khách hàng với tinh thần trách nhiệm cao nhất.</span></p>                                           \n                                                </div>', 'https://i-law.vn/Uploads/users/User_img_1570_07082020135858.jpg', NULL, NULL, NULL, NULL, 1, 5, 200000);
INSERT INTO `law_info` VALUES (5, 2, 'Hoàng Thị Huế', '0902293579', 'Quận Đống Đa, Thành phố Hà Nội', NULL, '1,2,3,4', 'Thạc sĩ - Luật sư Hoàng Thị Huế hiện là luật sư thuộc đoàn Luật sư Hà Nội.', '<div class=\"is-truncated\" data-truncate-lines=\"3\" id=\"js-truncated-aboutme\" data-truncate-label=\"Less <span aria-hidden=&quot;true&quot; class=&quot;icon fas fa-angle-up&quot;></span>\" aria-expanded=\"false\" style=\"overflow-wrap: break-word;\">\n                                                                                             <p>Thạc sĩ - Luật sư Hoàng Thị Huế hiện là luật sư thuộc đoàn Luật sư Hà Nội.</p><p>Luật sư Hoàng Thị Huế có nhiều năm kinh nghiệm hành nghề luật sư, thực hiện, hỗ trợ thành công và được sự đánh giá cao cho nhiều khách hàng tại tất cả các tỉnh thành trong các lĩnh vực:&nbsp;<span style=\"color: rgb(51, 51, 51); text-align: justify; font-size: 1.6rem;\">Tranh tụng, Hình sự, Dân sự, Hành chính, Đất đai, Thừa kế, Lao động, Kinh doanh - Thương mại, Hôn nhân và gia đình, Đầu tư- Doanh nghiệp.....bởi chuyên môn cao và sự tận tâm, nhiệt tình với công việc.&nbsp;</span></p><p><span style=\"color: rgb(51, 51, 51); text-align: justify; font-size: 1.6rem;\">Luật sư Hoàng Thị Huế hiện luật sư tư vấn thường xuyên và chuyên gia pháp lý cho rất nhiều các doanh nghiệp, làm việc với các đối tác lớn trong và ngoài nước. Đồng thời Luật sư Huế tham gia nhiều vụ án hình sự oan sai, truy tố oan sai....</span></p><p><span style=\"color: rgb(51, 51, 51); text-align: justify; font-size: 1.6rem;\">Trong quá trình hành nghề Luật sư, Luật sư Huế được rất nhiều khách hàng và đồng nghiệp đánh giá tốt cả về nghiệp vụ chuyên môn và trách nhiệm nghề nghiệp.</span></p><p><span style=\"color: rgb(51, 51, 51); text-align: justify; font-size: 1.6rem;\">Với phương châm: Chuyên môn, uy tín và chuyên nghiệp, Luật sư Huế đã đạt được nhiều thành công trong nghề nghiệp của mình.</span></p><p><br></p><p><br></p>                                         \n                                                </div>', 'https://i-law.vn/Uploads/users/User_img_927_27042021171906.jpeg', NULL, NULL, NULL, NULL, 1, 4, 200000);
COMMIT;

-- ----------------------------
-- Table structure for law_schedule_users
-- ----------------------------
DROP TABLE IF EXISTS `law_schedule_users`;
CREATE TABLE `law_schedule_users` (
  `id` int NOT NULL,
  `schedule_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `status` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `creator_id` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updator_id` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `schedule_id` (`schedule_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- ----------------------------
-- Records of law_schedule_users
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for law_schedules
-- ----------------------------
DROP TABLE IF EXISTS `law_schedules`;
CREATE TABLE `law_schedules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  `open_time` time DEFAULT NULL,
  `close_time` time DEFAULT NULL,
  `status` tinyint DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `creator_id` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updator_id` int DEFAULT NULL,
  `meeting_id` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `attendee_password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `moderator_password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- ----------------------------
-- Records of law_schedules
-- ----------------------------
BEGIN;
INSERT INTO `law_schedules` VALUES (8, 2, '2024-01-20', '08:00:00', '09:00:00', 1, '2024-01-17 10:24:43', 2, NULL, NULL, 'LAW_8_65a7ae6d4d24d', 'attendee_65a7ae6d4d24f', 'moderator_65a7ae6d4d250');
COMMIT;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
BEGIN;
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (3, '2023_07_11_075452_create_permission_tables', 2);
COMMIT;

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`) USING BTREE,
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`) USING BTREE,
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`) USING BTREE,
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`) USING BTREE,
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for payment_items
-- ----------------------------
DROP TABLE IF EXISTS `payment_items`;
CREATE TABLE `payment_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `payment_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `law_user_id` int DEFAULT NULL,
  `law_schedule_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `creator_id` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updator_id` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `payment_id` (`payment_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `law_user_id` (`law_user_id`) USING BTREE,
  KEY `law_schedule_id` (`law_schedule_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- ----------------------------
-- Records of payment_items
-- ----------------------------
BEGIN;
INSERT INTO `payment_items` VALUES (9, 12, 12, 3, NULL, 1, 150000, 1, '2024-01-17 10:23:22', 12, NULL, NULL);
INSERT INTO `payment_items` VALUES (10, 12, 12, 2, 8, 1, 200000, 1, '2024-01-17 10:23:22', 12, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for payments
-- ----------------------------
DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `status` tinyint DEFAULT NULL COMMENT '0: khởi tạo, 1: đã chuyển tiền, 2: hoàn thành, -1: đã xóa',
  `created_at` datetime DEFAULT NULL,
  `creator_id` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updator_id` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- ----------------------------
-- Records of payments
-- ----------------------------
BEGIN;
INSERT INTO `payments` VALUES (12, 12, 350000, 1, '2024-01-17 10:23:22', 12, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`) USING BTREE,
  KEY `role_has_permissions_role_id_foreign` (`role_id`) USING BTREE,
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_token` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menuroles` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `note` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gender` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `phone` (`phone`) USING BTREE,
  UNIQUE KEY `users_email_unique` (`email`) USING BTREE,
  UNIQUE KEY `users_api_token_unique` (`api_token`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES (1, 'admin', 'admin@admin.com45667', '0389941902', '2020-08-27 02:04:43', '$2y$10$K3hYeDUvn80AXkUJGC9yfuBsjf3yWuCn/XRWcmJ4nWqsOAo6phb/q', NULL, 'admin', 'Active', 'EQt3UDeo4F', '2020-08-27 02:04:43', '2021-07-23 08:07:52', NULL, 'hà nội', '2024-01-07', 'giới thiệu', 'male');
INSERT INTO `users` VALUES (2, 'law', NULL, '0389941904', NULL, '$2y$10$hqT51UeCEH/vtcrReqYWWuUijmlRiIboJxbJtD4I22xsEINEawZ3W', NULL, 'law', 'Active', NULL, '2024-01-10 10:01:15', '2024-01-10 10:01:15', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` VALUES (3, 'law1', NULL, '0380000000', NULL, '$2y$10$hqT51UeCEH/vtcrReqYWWuUijmlRiIboJxbJtD4I22xsEINEawZ3W', NULL, 'law', 'Active', NULL, '2024-01-10 10:01:15', '2024-01-10 10:01:15', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` VALUES (4, 'law2', NULL, '0380000002', NULL, '$2y$10$hqT51UeCEH/vtcrReqYWWuUijmlRiIboJxbJtD4I22xsEINEawZ3W', NULL, 'law', 'Active', NULL, '2024-01-10 10:01:15', '2024-01-10 10:01:15', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` VALUES (5, 'law3', NULL, '0380000003', NULL, '$2y$10$hqT51UeCEH/vtcrReqYWWuUijmlRiIboJxbJtD4I22xsEINEawZ3W', NULL, 'law', 'Active', NULL, '2024-01-10 10:01:15', '2024-01-10 10:01:15', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` VALUES (6, 'law4', NULL, '0380000004', NULL, '$2y$10$hqT51UeCEH/vtcrReqYWWuUijmlRiIboJxbJtD4I22xsEINEawZ3W', NULL, 'law', 'Active', NULL, '2024-01-10 10:01:15', '2024-01-10 10:01:15', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` VALUES (12, 'demo', NULL, '0389941903', NULL, '$2y$10$cqkTt3YmjVorFViRGDhcv.DPqP557Qbz1c5lKmEJm8bnlBPOdeSgS', NULL, 'user', 'Active', NULL, '2024-01-10 09:15:37', '2024-01-10 09:15:37', NULL, NULL, NULL, NULL, NULL);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;

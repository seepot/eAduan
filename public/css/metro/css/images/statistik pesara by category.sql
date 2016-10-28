-------------- Satsistik By Pangkat -------
/*Darat---*/
<-- TERBITAN
SELECT     Service.RankCode, RtmRank.RankShortDesc, RtmRank.RankDesc, RtmRank.IsOfficer, COUNT(Service.RankCode) AS Jumlh_Tentera_Darat
FROM         Service INNER JOIN
                      RtmRank ON Service.RankCode = RtmRank.Rankcode
WHERE     (Service.RankCode LIKE N'1%') AND (Service.PensionerRefID IN
                          (SELECT DISTINCT PensionerRefID
                            FROM          Account
                            WHERE      (BenefitCode IN ('33','41', '43')) AND (CurrentPaymentMethod IN ('101', '207'))))
GROUP BY Service.RankCode, RtmRank.RankShortDesc, RtmRank.RankDesc, RtmRank.IsOfficer
ORDER BY Service.RankCode

<--PESARA
SELECT     Service.RankCode, RtmRank.RankShortDesc, RtmRank.RankDesc, RtmRank.IsOfficer, COUNT(Service.RankCode) AS Jumlh_Tentera_Darat
FROM         Service INNER JOIN
                      RtmRank ON Service.RankCode = RtmRank.Rankcode
WHERE     (Service.RankCode LIKE N'1%') AND (Service.PensionerRefID IN
                          (SELECT DISTINCT PensionerRefID
                            FROM          Account
                            WHERE      (BenefitCode IN ('03', '06', '15')) AND (CurrentPaymentMethod IN ('101', '207'))))
GROUP BY Service.RankCode, RtmRank.RankShortDesc, RtmRank.RankDesc, RtmRank.IsOfficer
ORDER BY Service.RankCode


--Laut--
<--TERBITAN
SELECT      Service.RankCode, RtmRank.RankShortDesc, RtmRank.RankDesc, RtmRank.IsOfficer,COUNT(Service.RankCode) AS Jumlh_Tentera_Laut
FROM         Service INNER JOIN
                      RtmRank ON Service.RankCode = RtmRank.Rankcode
WHERE      (Service.RankCode LIKE N'2%')  and (Service.PensionerRefID IN
                          (SELECT DISTINCT PensionerRefID
                            FROM          Account
                            WHERE      (BenefitCode IN ('33', '43', '41')) AND (CurrentPaymentMethod IN ('101', '207'))))
GROUP BY Service.RankCode, RtmRank.RankShortDesc, RtmRank.RankDesc, RtmRank.IsOfficer
ORDER BY Service.RankCode

<--PESARA
SELECT      Service.RankCode, RtmRank.RankShortDesc, RtmRank.RankDesc, RtmRank.IsOfficer,COUNT(Service.RankCode) AS Jumlh_Tentera_Laut
FROM         Service INNER JOIN
                      RtmRank ON Service.RankCode = RtmRank.Rankcode
WHERE      (Service.RankCode LIKE N'2%')  and (Service.PensionerRefID IN
                          (SELECT DISTINCT PensionerRefID
                            FROM          Account
                            WHERE      (BenefitCode IN ('03', '06', '15')) AND (CurrentPaymentMethod IN ('101', '207'))))
GROUP BY Service.RankCode, RtmRank.RankShortDesc, RtmRank.RankDesc, RtmRank.IsOfficer
ORDER BY Service.RankCode

--Udara--

<--PESARA
SELECT      Service.RankCode, RtmRank.RankShortDesc, RtmRank.RankDesc, RtmRank.IsOfficer,COUNT(Service.RankCode) AS Jumlh_Tentera_Udara
FROM         Service INNER JOIN
                      RtmRank ON Service.RankCode = RtmRank.Rankcode
WHERE      (Service.RankCode LIKE N'3%')  and (Service.PensionerRefID IN
                          (SELECT DISTINCT PensionerRefID
                            FROM          Account
                            WHERE      (BenefitCode IN ('03', '06', '15')) AND (CurrentPaymentMethod IN ('101', '207'))))
GROUP BY Service.RankCode, RtmRank.RankShortDesc, RtmRank.RankDesc, RtmRank.IsOfficer
ORDER BY Service.RankCode

SELECT *FROM RTMBENEFIT
<--TERBITAN

SELECT      Service.RankCode, RtmRank.RankShortDesc, RtmRank.RankDesc, RtmRank.IsOfficer,COUNT(Service.RankCode) AS Jumlh_Tentera_Udara
FROM         Service left outer JOIN
                      RtmRank ON Service.RankCode = RtmRank.Rankcode
WHERE      (Service.RankCode LIKE N'3%')  and (Service.PensionerRefID IN
                          (SELECT DISTINCT PensionerRefID
                            FROM          Account
                            WHERE      (BenefitCode IN ('33', '43', '41')) AND (CurrentPaymentMethod IN ('101', '207'))))
GROUP BY Service.RankCode, RtmRank.RankShortDesc, RtmRank.RankDesc, RtmRank.IsOfficer
ORDER BY Service.RankCode

--- Statitik mengikut Perkhidmatan bg tidak berpencen ---

SELECT DISTINCT PensionerRefID AS Jumlah_Tentera_Darat
FROM         Service
WHERE     (RankCode LIKE N'001%')  and PensionerRefID not in (Select distinct PensionerRefID from account where benefitcode
 in('33','43','41','03', '06', '09') and currentpaymentmethod in ('101','207'))

SELECT DISTINCT PensionerRefID AS Jumlah_Tentera_Darat
FROM         Service
WHERE     (RankCode LIKE N'1%')  and PensionerRefID not in (Select distinct PensionerRefID from account where benefitcode
 in('33','43','41','03', '06', '09') and currentpaymentmethod in ('101','207'))

SELECT PensionerRefID AS Jumlah_Tentera_Darat
FROM         Service
WHERE     (RankCode LIKE N'2%')  and PensionerRefID not in (Select distinct PensionerRefID from account where benefitcode
 in('33','43','41','03', '06', '09') and currentpaymentmethod in ('101','207'))

SELECT PensionerRefID AS Jumlah_Tentera_Darat
FROM         Service
WHERE     (RankCode LIKE N'3%')  and PensionerRefID not in (Select distinct PensionerRefID from account where benefitcode
 in('33','43','41','03', '06', '09') and currentpaymentmethod in ('101','207'))

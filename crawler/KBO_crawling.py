import pandas as pd
import requests
from bs4 import BeautifulSoup as bs
from sqlalchemy import create_engine
from sqlalchemy.sql import text

# MySQL 접속 설정
user = "phmn"
password = "1204"
host = "localhost"
database = "DB_baseball"
charset = "utf8mb4"

engine = create_engine(f'mysql+pymysql://{user}:{password}@{host}/{database}?charset={charset}')

# 기록실 사이트 리스트로 정리
url_base = 'https://www.koreabaseball.com/Record/Player/{category}'
category_list = ['HitterBasic/Basic1.aspx', 'PitcherBasic/Basic1.aspx']

data_list = []
team_dict = {}

# 타자와 투수 데이터 크롤링
for category in category_list:
    url = url_base.format(category=category)
    req = requests.get(url)

    html = req.text
    soup = bs(html, 'html.parser')
    temp_table = soup.find('div', {'class': 'record_result'})
    col_tag = temp_table.find_all('td')
    col_list = ['순위', '이름', '팀']

    for col in col_tag:
        try:
            temp_value = col.attrs['data-id']
            temp_value = temp_value.replace('_CN', '')
            if temp_value not in col_list: col_list.append(temp_value)
            else: break
            
        except: pass

    # 임시 DataFrame 생성
    temp_data = pd.DataFrame(columns=col_list)

    # 데이터를 추출해 DataFrame에 저장
    i = 0
    index = 0
    col_len = len(col_list)
    while True:
        try:
            temp_data.loc[i] = [x.text for x in temp_table.find_all('td')[index:index + col_len]]
            i += 1
            index += col_len
        except: break

    temp_data['팀'] = [team_dict.setdefault(team_name, len(team_dict) + 1) for team_name in temp_data['팀']]
    temp_data.insert(0, 'ID', [f"{category.split('/')[0]}_{i}" for i in range(1, len(temp_data) + 1)])
    data_list.append(temp_data)

team_data = pd.DataFrame({'팀ID': list(team_dict.values()), '팀명': list(team_dict.keys())})
team_data.to_sql(name='팀', con=engine, if_exists='replace', index=False)

# 팀 순위 데이터 수집
team_url = 'https://www.koreabaseball.com/Record/TeamRank/TeamRankDaily.aspx'
team_req = requests.get(team_url)
team_html = team_req.text
team_soup = bs(team_html, 'html.parser')

team_table = team_soup.find('table', {'class': 'tData'})
team_col_tag = team_table.find_all('th')
team_col_list = [col.text.strip() for col in team_col_tag]

# 임시 DataFrame 생성
team_data = pd.DataFrame(columns=team_col_list)

# 테이블의 데이터를 추출해 DataFrame에 저장
team_rows = team_table.find_all('tr')[1:]
for row in team_rows:
    team_data.loc[len(team_data)] = [cell.text.strip() for cell in row.find_all('td')]

team_data['팀ID'] = [team_dict.setdefault(team_name, len(team_dict) + 1) for team_name in team_data['팀명']]

# id를 추가해 DataFrame에 저장
team_data.insert(0, 'ID', [f"팀_{i}" for i in range(1, len(team_data) + 1)])
data_list.append(team_data)
table_names = ['타자', '투수', '팀']

with engine.connect() as con:
    for table_name in table_names:
        con.execute(text(f"DROP TABLE IF EXISTS {table_name}"))

for i, (table_name, df) in enumerate(zip(table_names, data_list)):
    if table_name == '타자' or table_name == '투수':
        df = df.rename(columns={'순위': '순위', '이름': '이름', '팀': '팀ID'})
        
    elif table_name == '팀':
        df = df.rename(columns={'순위': '순위', '팀': '팀명'})
    
    df.to_sql(name=table_name, con=engine, if_exists='replace', index=False)

print("테이블이 업데이트되었습니다.")
import proxy from "@/utils/proxy";

const host = "http://music.163.com/api"

export const get_netmusic_toplist = () => proxy({
  url: `${host}/toplist`,
});
export const get_netmusic_playlist = id => proxy({
  url: `${host}/playlist/detail`,
  params: {
    id
  }
});
export const get_netmusic_lyric = id => proxy({
  url: `${host}/song/lyric`,
  params: {
    id
  }
});
export const get_netmusic_song = ids => proxy({
  url: `${host}/song/detail`,
  params: {
    ids: ids.map(v => v.id).join(",")
  }
});
export const get_netmusic_song_url = ids => proxy({
  url: `${host}/song/player/url`,
  params: {
    ids: ids.map(v => v.id).join(",")
  }
});
export const get_netmusic_playlist_catlist = () => proxy({
  url: `${host}/playlist/catalogue`
});

export const get_netmusic_playlist_top = ({ cat = "全部", pageNum = 1 }) => proxy({
  url: `${host}/playlist/list`,
  params: {
    cat,
    pageNum
  }
});

export const get_netmusic_artist_list = ({ type, area, pageNum }) => proxy({
  url: `${host}/artist/list`,
  params: {
    initial: undefined,
    offset: (pageNum - 1) * 100,
    limit: 100,
    total: true,
    type: type,
    area: area
  }
});

export const get_netmusic_artist_top_songs = id => proxy({
  url: `${host}/artist/top/song`,
  params: {
    id
  }
});
